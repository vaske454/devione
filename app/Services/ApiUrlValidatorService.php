<?php

namespace App\Services;

use InvalidArgumentException;

class ApiUrlValidatorService
{
    /**
     * Check if the API URL is valid.
     *
     * @param string $apiUrl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isValidApiUrl(string $apiUrl): bool
    {
        // Check if the URL is empty
        if (empty($apiUrl)) {
            throw new InvalidArgumentException('API URL is empty.', 500);
        }

        // Check if the URL exactly matches the expected URL
        $expectedUrl = 'https://api.dictionaryapi.dev/api/v2/entries/en';
        if ($apiUrl !== $expectedUrl) {
            throw new InvalidArgumentException('Invalid API URL.', 500);
        }

        // Check if the URL has a valid format
        if (!filter_var($apiUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL format.', 500);
        }

        return true;
    }
}
