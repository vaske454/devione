<?php

namespace App\Http\Controllers;

use App\Services\WordValidatorService;
use App\Services\WordScorerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WordGameController extends Controller
{
    protected WordValidatorService $wordValidatorService;
    protected WordScorerService $wordScorerService;

    public function __construct(WordValidatorService $wordValidatorService, WordScorerService $wordScorerService)
    {
        $this->wordValidatorService = $wordValidatorService;
        $this->wordScorerService = $wordScorerService;
    }

    /**
     * Check the word entered by the user and return its score.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkWord(Request $request): JsonResponse
    {
        $word = $request->input('word');

        // Validate input
        $request->validate([
            'word' => 'required|string'
        ]);

        // Check if the word is valid
        if (!$this->wordValidatorService->isValidWord($word)) {
            return response()->json(['error' => 'Invalid word'], 422);
        }

        // Calculate score
        $score = $this->wordScorerService->calculateScore($word);

        return response()->json(['score' => $score]);
    }
}
