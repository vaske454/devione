<?php

namespace App\Http\Controllers;

use App\Services\ApiUrlValidatorService;
use App\Services\WordValidatorService;
use App\Services\WordScorerService;
use Exception;
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
     * @throws Exception
     */
    protected function validateApiUrl(): void
    {
        $apiUrl = config('services.dictionary_api.url');
        $this->apiUrlValidatorService->isValidApiUrl($apiUrl);
    }

    /**
     * Check the word entered by the user and return its score.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function checkWord(Request $request): JsonResponse
    {
        // Validate API URL
        $this->validateApiUrl();

        // Extract input
        $word = $request->input('word');

        // Validate input
        $request->validate([
            'word' => ['required', 'regex:/^[A-Za-z]+$/i', 'min:2', 'max:50']
        ], [
            'word.regex' => 'Invalid word'
        ]);

        // Check if the word is valid
        $this->wordValidatorService->isValidWord($word);

        try {
            // Calculate score
            $score = $this->wordScorerService->calculateScore($word);

            return response()->json(['score' => $score]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
