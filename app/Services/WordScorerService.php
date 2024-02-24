<?php

namespace App\Services;

class WordScorerService
{
    /**
     * Calculate the score for the given word.
     *
     * @param string $word
     * @return int
     */
    public function calculateScore(string $word): int
    {
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
