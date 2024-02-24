<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WordGameService
{
    protected string $apiUrl = 'https://api.dictionaryapi.dev/api/v2/entries/en';

    /**
     * Check if the given word is valid and calculate its score.
     *
     * @param string $word
     * @return int
     */
    public function calculateScore(string $word): int
    {
        if (!$this->isValidWord($word)) {
            return 0;
        }

        $score = $this->calculateUniqueLetterScore($word);

        if ($this->isPalindrome($word)) {
            $score += 3;
        }

        if ($this->isAlmostPalindrome($word)) {
            $score += 2;
        }

        return $score;
    }

    /**
     * Check if the word exists in the English dictionary.
     *
     * @param string $word
     * @return bool
     */
    private function isValidWord(string $word): bool
    {
        $response = Http::get("$this->apiUrl/$word");
        return $response->successful();
    }

    /**
     * Calculate the score based on the number of unique letters in the word.
     *
     * @param string $word
     * @return int
     */
    private function calculateUniqueLetterScore(string $word): int
    {
        $uniqueLetters = array_unique(str_split($word));
        return count($uniqueLetters);
    }

    /**
     * Check if the word is a palindrome.
     *
     * @param string $word
     * @return bool
     */
    private function isPalindrome(string $word): bool
    {
        return $word === strrev($word);
    }

    /**
     * Check if the word is almost a palindrome.
     *
     * @param string $word
     * @return bool
     */
    private function isAlmostPalindrome(string $word): bool
    {
        $length = strlen($word);
        $i = 0;
        $j = $length - 1;
        while ($i < $j) {
            if ($word[$i] !== $word[$j]) {
                return $this->isPalindrome(substr_replace($word, '', $i, 1)) ||
                    $this->isPalindrome(substr_replace($word, '', $j, 1));
            }
            $i++;
            $j--;
        }
        return true;
    }
}
