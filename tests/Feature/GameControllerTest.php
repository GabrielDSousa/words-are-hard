<?php

use App\Models\GameSession;
use App\Models\User;
use App\Models\Word;
use App\Services\WordsApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    Cache::flush();
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// Teste do método index
test('displays the user\'s game dashboard', function () {
    GameSession::factory()->for($this->user)->create(['status' => 'finished']);
    GameSession::factory()->for($this->user)->create(['status' => 'in_progress']);

    get(route('dashboard'))
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('Dashboard')
                ->has('games', 1)
                ->has('continue', fn($page) => $page->where('status', 'in_progress')->etc())
        );
});

// Teste do método store
test('creates a new game session', function () {
    Word::factory()->create(['text' => 'example']);

    $mock = $this->mock(WordsApiService::class);
    $mock->shouldReceive('random')->andReturnSelf();
    $mock->shouldReceive('getWord')->andReturn(Word::first());

    post(route('start.game'))
        ->assertRedirect(route('current.game', ['id' => GameSession::first()->id]));

    expect(GameSession::count())->toBe(1);
    expect(Cache::has(GameSession::first()->id))->toBeTrue();
});

// Teste do método show
test('displays the current game session', function () {
    $word = Word::factory()->create(['text' => 'example']);
    $game = GameSession::factory()->for($this->user)->create([
        'word_id' => $word->id,
        'status' => 'in_progress',
    ]);

    Cache::forever($game->id, collect([
        'gameSession' => $game,
        'history' => collect(['first_guess']),
        'disabled' => false
    ]));

    get(route('current.game', $game->id))
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('CurrentGame')
                ->where('game.id', $game->id)
                ->where('size', strlen($word->text))
                ->has('history', 1)
                ->where('disabled', false)
        );
});

// Teste do método update com palavra válida
test('updates the game session with a valid word', function () {
    $word = Word::factory()->create(['text' => 'example']);
    $game = GameSession::factory()->for($this->user)->create(['word_id' => $word->id, 'attempts_left' => 5, 'lives' => 3, 'status' => 'in_progress']);
    Cache::forever($game->id, collect(['game' => $game, 'history' => collect(), 'disabled' => false]));

    $mock = $this->mock(WordsApiService::class);
    $mock->shouldReceive('isValidWord')->with('guess')->andReturn(true);

    put(route('update.game', $game->id), ['guess' => 'guess'])
        ->assertRedirect(route('current.game', $game->id));

    $updatedGame = $game->fresh();
    expect($updatedGame->attempts_left)->toBe(4);
    expect(Cache::get($game->id)['history']->count())->toBe(1);
    expect(Cache::get($game->id)['history']->first()->count())->toBe(5);
    expect(Cache::get($game->id)['history']->first()->first()['letter'])->toBe('g');
    expect(Cache::get($game->id)['history']->first()->first()['position'])->toBe(0);
    expect(Cache::get($game->id)['history']->first()->first()['status'])->toBe('incorrect');
});

// Teste do método update com tentativa sem vidas restantes
test('ends game session if no lives are left after invalid guess', function () {
    $word = Word::factory()->create(['text' => 'example']);
    $game = GameSession::factory()->for($this->user)->create(['word_id' => $word->id, 'attempts_left' => 1, 'lives' => 0, 'status' => 'in_progress']);
    Cache::forever($game->id, collect(['game' => $game, 'history' => collect(), 'disabled' => false]));

    $mock = $this->mock(WordsApiService::class);
    $mock->shouldReceive('isValidWord')->with('wrong')->andReturn(true);

    put(route('update.game', $game->id), ['guess' => 'wrong'])
        ->assertRedirect('dashboard');

    $updatedGame = $game->fresh();
    expect($updatedGame->status)->toBe('finished');
    expect(Cache::has($game->id))->toBeFalse();
});
