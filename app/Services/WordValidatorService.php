<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class WordValidatorService
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.dictionary_api.url');
    }

    /**
     * Checks if the given word is valid.
     *
     * @param string $word
     * @return bool
     * @throws RequestException
     */
    public function isValidWord(string $word): bool
    {
        $response = Http::get("$this->apiUrl/$word");
        $response->throw();
        return true;
    }
}
