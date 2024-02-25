<?php

namespace App\Services;

use Exception;

class ApiUrlValidatorService
{
    /**
     * Check if the API URL is valid.
     *
     * @param string $apiUrl
     * @return bool
     * @throws Exception
     */
    public function isValidApiUrl(string $apiUrl): bool
    {
        // Check if the URL is empty
        if (empty($apiUrl)) {
            throw new Exception('API URL is empty.');
        }

        // Check if the URL exactly matches the expected URL
        $expectedUrl = 'https://api.dictionaryapi.dev/api/v2/entries/en';
        if ($apiUrl !== $expectedUrl) {
            throw new Exception('Invalid API URL.');
        }

        // Check if the URL has a valid format
        if (!filter_var($apiUrl, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid URL format.');
        }

        return true;
    }
}
