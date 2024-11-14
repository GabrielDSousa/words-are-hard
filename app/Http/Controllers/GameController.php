<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use App\Models\Word;
use App\Services\WordsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class GameController extends Controller
{
    public function __construct(protected WordsApiService $wordsApiService)
    {
        // Injeção automática
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = request()->user()->games;


        return Inertia::render('Dashboard', [
            'games' => $games->where('status', 'finished')->sortBy('updated_at') === [] ? null : $games->where('status', 'finished')->sortBy('updated_at'),
            'continue' => $games->where('status', 'in_progress')->first()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $game = GameSession::create([
            'user_id' => request()->user()->id,
            'word_id' => ($this->wordsApiService->random()->getWord())->id,
            'round' => 0,
            'score' => 0,
            'attempts_left' => 5,
            'lives' => 3,
            'status' => 'in_progress'
        ]);

        Cache::forever($game->id, collect([
            'gameSession' => $game,
            'history' => collect([]),
            'disabled' => false
        ]));

        return redirect(route('current.game', ['id' => $game->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = GameSession::where('id', $id)->first();
        $history = Cache::get($game->id)->get('history');

        return Inertia::render('CurrentGame', [
            'game' => $game,
            'size' => strlen(Word::where('id', $game->word_id)->first()->text),
            'history' => $history,
            'word' => app()->environment('local') ? Word::where('id', $game->word_id)->first()->text : null,
            'disabled' => Cache::get($game->id)->get('disabled')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'guess' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!$this->wordsApiService->isValidWord($value)) {
                        $fail('The ' . $attribute . ' must be a valid word.');
                    }
                },
            ],
        ]);

        $game = GameSession::where('id', $id)->first();

        if ($game->attempts_left > 1) {
            $game->attempts_left--;
        } else {
            if ($game->lives === 0) {
                $game->gameOver();
                $game->save();
                Cache::flush();
                return redirect('dashboard');
            }

            $game->attempts_left--;
        }

        $game->save();

        $cachedGame = Cache::pull($id);
        Cache::forever(
            $id,
            collect([
                'game' => $game,
                'history' => $cachedGame->get('history')->push(Word::where('id', $game->word_id)->first()->compareWord($validated['guess'])),
                'disabled' => $game->attempts_left === 0
            ])
        );

        return redirect(route('current.game', $id));
    }
}
