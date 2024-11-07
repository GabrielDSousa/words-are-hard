<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WordsApiService
{
    protected $apiHost;
    protected $apiKey;

    public function __construct()
    {
        $this->apiHost = config('services.wordsapi.host');
        $this->apiKey = config('services.wordsapi.key');
    }

    /**
     * Retorna uma palavra aleatória da API.
     *
     * @return string|null
     */
    public function getRandomWord()
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get("https://{$this->apiHost}/words/", ['random' => 'true']);

        return $response->successful() ? $response->json('word') : null;
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
