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
        try {
            $response = Http::get("$this->apiUrl/$word");
            $response->throw();
            return true;
        } catch (RequestException $e) {
            // Handle the exception
            if ($e->response && $e->response->status() === 404) {
                throw new \InvalidArgumentException('Invalid word', 404);
            }
            // Re-throw the exception if it's not a 404 error
            throw $e;
        }
    }
}
