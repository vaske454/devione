<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WordValidatorService
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.dictionary_api.url');
    }

    /**
     * Check if the given word is valid.
     *
     * @param string $word
     * @return bool
     */
    public function isValidWord(string $word): bool
    {
        $response = Http::get("$this->apiUrl/$word");
        return $response->successful();
    }
}
