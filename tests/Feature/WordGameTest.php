<?php

namespace Tests\Feature;

use Tests\TestCase;

class WordGameTest extends TestCase
{
    /**
     * Test checking a valid single word.
     *
     * @return void
     */
    public function testCheckValidSingleWord()
    {
        // Testing the word "test"
        $response = $this->postJson('/api/check-word', ['word' => 'test']);
        $response->assertStatus(200)
            ->assertJson(['score' => 5]); // Expecting a score of 5
    }

    /**
     * Test checking another valid single word.
     *
     * @return void
     */
    public function testCheckAnotherValidSingleWord()
    {
        // Testing the word "apple"
        $response = $this->postJson('/api/check-word', ['word' => 'apple']);
        $response->assertStatus(200)
            ->assertJson(['score' => 4]); // Expecting a score of 4
    }

    /**
     * Test checking a palindrome word.
     *
     * @return void
     */
    public function testCheckPalindromeWord()
    {
        // Testing the word "level" (palindrome)
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(200)
            ->assertJson(['score' => 8]); // Expecting a score of 8 (1 point per letter + 3 points for palindrome)
    }

    /**
     * Test checking an invalid word.
     *
     * @return void
     */
    public function testCheckInvalidWord()
    {
        // Testing an invalid word "xyz"
        $response = $this->postJson('/api/check-word', ['word' => 'xyz']);
        $response->assertStatus(500); // Expecting status 422 because the word is invalid
    }

    /**
     * Test checking an empty word.
     *
     * @return void
     */
    public function testCheckEmptyWord()
    {
        // Testing an empty word
        $response = $this->postJson('/api/check-word', ['word' => '']);
        $response->assertStatus(422); // Expecting status 422 because the word is empty
    }

    /**
     * Test checking without providing a word.
     *
     * @return void
     */
    public function testCheckWithoutProvidingWord()
    {
        // Testing without providing a word
        $response = $this->postJson('/api/check-word');
        $response->assertStatus(422); // Expecting status 422 because no word is provided
    }

    /**
     * Test checking with a numeric word.
     *
     * @return void
     */
    public function testCheckNumericWord()
    {
        // Testing with a numeric word "4"
        $response = $this->postJson('/api/check-word', ['word' => '4']);
        $response->assertStatus(422); // Expecting status 422 because a numeric word is provided
    }

    /**
     * Test checking with a word containing special characters.
     *
     * @return void
     */
    public function testCheckWordWithSpecialCharacters()
    {
        // Testing with a word with special characters like $
        $response = $this->postJson('/api/check-word', ['word' => '$']);
        $response->assertStatus(422); // Expecting status 422 because a word with a special character is provided
    }

    /**
     * Test checking a word with spaces.
     *
     * @return void
     */
    public function testCheckWordWithSpaces()
    {
        // Testing with a word with spaces
        $response = $this->postJson('/api/check-word', ['word' => 'word game']);
        $response->assertStatus(422); // Expecting status 422 because a word with spaces is provided
    }

    /**
     * Test checking a Serbian word.
     *
     * @return void
     */
    public function testCheckSerbianWord()
    {
        // Testing a Serbian word
        $response = $this->postJson('/api/check-word', ['word' => 'čokolada']);
        $response->assertStatus(422); // Expecting status 422 because it is not an English word
    }

    /**
     * Test checking multiple words in one request.
     *
     * @return void
     */
    public function testCheckMultipleWordsInOneRequest()
    {
        // Testing multiple words in one request
        $response = $this->postJson('/api/check-word', ['words' => ['apple', 'banana']]);
        $response->assertStatus(422); // Expecting status 422 because multiple words are provided in one request
    }

    /**
     * Testing words that are anagrams of each other.
     *
     * @return void
     */
    public function testCheckAnagramWords()
    {
        // Testing anagrams: 'listen' and 'silent'
        $response = $this->postJson('/api/check-word', ['word' => 'listen']);
        $response->assertStatus(200)
            ->assertJson(['score' => 6]); // Expecting a score of 6 for 'listen'

        // Testing anagrams: 'silent' and 'listen'
        $response = $this->postJson('/api/check-word', ['word' => 'silent']);
        $response->assertStatus(200)
            ->assertJson(['score' => 6]); // Expecting a score of 6 for 'silent'
    }

    /**
     * Testing processing of long words.
     *
     * @return void
     */
    public function testCheckLongWord()
    {
        // Testing processing of a very long word
        $response = $this->postJson('/api/check-word', ['word' => 'pneumonoultramicroscopicsilicovolcanoconiosis']);
        $response->assertStatus(200); // Expecting status 200 for successful processing
    }

    /**
     * Testing handling of different word variants.
     *
     * @return void
     */
    public function testCheckWordCaseInsensitive()
    {
        // Testing word with uppercase letters
        $response = $this->postJson('/api/check-word', ['word' => 'WORD']);
        $response->assertStatus(200)
            ->assertJson(['score' => 4]); // Expecting a score of 4 for 'WORD'
    }
}
