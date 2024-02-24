<?php

namespace App\Http\Controllers;

use App\Services\WordGameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WordGameController extends Controller
{
    protected WordGameService $wordGameService;

    public function __construct(WordGameService $wordGameService)
    {
        $this->wordGameService = $wordGameService;
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

        // Calculate score
        $score = $this->wordGameService->calculateScore($word);

        return response()->json(['score' => $score]);
    }
}
