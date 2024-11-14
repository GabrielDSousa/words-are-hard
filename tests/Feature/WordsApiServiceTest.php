<?php

use App\Models\Word;
use App\Services\WordsApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    // Configura os mocks de configuração
    Config::set('services.wordsapi.host', config('services.wordsapi.host'));
    Config::set('services.wordsapi.key', config('services.wordsapi.key'));
});

test('it applies random filter when calling random method', function () {
    $service = new WordsApiService();
    $service->random();

    // Usa reflection para acessar a propriedade privada filters
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('filters');
    $property->setAccessible(true);

    expect($property->getValue($service))->toHaveKey('random', 'true');
});

test('it retrieves a word from the API and stores it if not exists', function () {
    $service = new WordsApiService();
    $service->random();
    $result = $service->getWord();

    expect($result)->toBeInstanceOf(Word::class);
});

test('it verifies if a word is valid via the API', function () {
    $service = new WordsApiService();
    $result = $service->isValidWord('word');

    expect($result)->toBeTrue();
});

test('it returns false if API response is unsuccessful in isValidWord', function () {
    $service = new WordsApiService();
    $result = $service->isValidWord('inválida');

    expect($result)->toBeFalse();
});
