<?php

namespace App\Http\Controllers;

use App\Services\ApiUrlValidatorService;
use App\Services\WordValidatorService;
use App\Services\WordScorerService;
use Illuminate\Http\Client\RequestException;
use InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WordGameController extends Controller
{
    protected ApiUrlValidatorService $apiUrlValidatorService;
    protected WordValidatorService $wordValidatorService;
    protected WordScorerService $wordScorerService;

    public function __construct(ApiUrlValidatorService $apiUrlValidatorService, WordValidatorService $wordValidatorService, WordScorerService $wordScorerService)
    {
        $this->apiUrlValidatorService = $apiUrlValidatorService;
        $this->wordValidatorService = $wordValidatorService;
        $this->wordScorerService = $wordScorerService;
    }

    /**
     * Validate the API URL.
     *
     * @throws InvalidArgumentException
     */
    protected function validateApiUrl(): void
    {
        $apiUrl = config('services.dictionary_api.url');
        $this->apiUrlValidatorService->isValidApiUrl($apiUrl);
    }

    /**
     * Process the word and return its score.
     *
     * @param string $word
     * @return array
     * @throws InvalidArgumentException|RequestException
     */
    private function processWord(string $word): array
    {
        // Validate API URL
        $this->validateApiUrl();

        // Validate input
        $this->wordValidatorService->isValidWord($word);

        // Calculate score
        $score = $this->wordScorerService->calculateScore($word);

        return compact('score');
    }

    /**
     * Check the word entered by the user and return its score.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException|RequestException
     */
    public function checkWord(Request $request): JsonResponse
    {
        // Extract input
        $word = $request->input('word');

        // Validate input
        $request->validate([
            'word' => ['required', 'regex:/^[A-Za-z]+$/i', 'min:2', 'max:50']
        ], [
            'word.regex' => 'Invalid word'
        ]);

        try {
            // Process the word
            $result = $this->processWord($word);

            return response()->json($result);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Check the score for a single word when the command is run in the terminal.
     *
     * @param string $word
     * @return JsonResponse
     * @throws InvalidArgumentException|RequestException
     */
    public function checkWordCommand(string $word): JsonResponse
    {
        // Validate input
        if (strlen($word) < 2 || strlen($word) > 50) {
            throw new InvalidArgumentException('Word length must be between 2 and 50 characters.');
        }

        // Check for special characters
        if (!preg_match('/^[A-Za-z]+$/', $word)) {
            throw new InvalidArgumentException('Word must contain only letters.');
        }


        // Process the word
        $result = $this->processWord($word);
        try {
            return response()->json($result);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
