<?php

namespace App\Services;

use App\Models\Word;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class WordsApiService
{
    protected $apiHost;
    protected $apiKey;
    protected $filters;

    public function __construct()
    {
        $this->apiHost = config('services.wordsapi.host');
        $this->apiKey = config('services.wordsapi.key');
        $this->filters = ['letterPattern' => '^[A-Za-z]+$', 'limit' => '1', 'frequencymin' => '1.74', 'frequencymax' => '8.03', 'hasDetails' => 'frequency'];
    }

    /**
     * Adiciona a flag para palavra aleatória
     *
     */
    public function random(): self
    {
        $this->filters['random'] = 'true';
        return $this;
    }

    /**
     * Retorna as informações de uma palavra.
     *
     * @return Word|null
     */
    public function getWord(array $extra = []): Word | null
    {
        array_merge($this->filters, $extra);
        $response = Http::withHeaders($this->getHeaders())
            ->get("https://{$this->apiHost}/words/", $this->filters);

        $data = $response->json();

        $word = Word::where('text', $data['word'])->first() ?? Word::create(['text' => $data['word'], 'frequency' => $data['frequency'], 'info' => json_encode(Arr::except($data, ['word', 'frequency']))]);
        return $response->successful() ? $word : null;
    }

    /**
     * Verifica se uma palavra é válida.
     *
     * @param string $word
     * @return bool
     */
    public function isValidWord(string $word)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get("https://{$this->apiHost}/words/{$word}");

        return $response->successful();
    }

    /**
     * Configura os headers da requisição para a WordsAPI.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'x-rapidapi-host' => $this->apiHost,
            'x-rapidapi-key' => $this->apiKey,
        ];
    }
}
