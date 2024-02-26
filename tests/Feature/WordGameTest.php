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
        $response = $this->postJson('/api/check-word', ['word' => 'test']);
        $response->assertStatus(200)
            ->assertJson(['score' => 5]);
    }

    /**
     * Test checking another valid single word.
     *
     * @return void
     */
    public function testCheckAnotherValidSingleWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'apple']);
        $response->assertStatus(200)
            ->assertJson(['score' => 4]);
    }

    /**
     * Test checking a palindrome word.
     *
     * @return void
     */
    public function testCheckPalindromeWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(200)
            ->assertJson(['score' => 8]);
    }

    /**
     * Test checking an invalid word.
     *
     * @return void
     */
    public function testCheckInvalidWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'xyz']);
        $response->assertStatus(500);
    }

    /**
     * Test checking an empty word.
     *
     * @return void
     */
    public function testCheckEmptyWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => '']);
        $response->assertStatus(422);
    }

    /**
     * Test checking without providing a word.
     *
     * @return void
     */
    public function testCheckWithoutProvidingWord()
    {
        $response = $this->postJson('/api/check-word');
        $response->assertStatus(422);
    }

    /**
     * Test checking with a numeric word.
     *
     * @return void
     */
    public function testCheckNumericWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => '4']);
        $response->assertStatus(422);
    }

    /**
     * Test checking with a word containing special characters.
     *
     * @return void
     */
    public function testCheckWordWithSpecialCharacters()
    {
        $response = $this->postJson('/api/check-word', ['word' => '$']);
        $response->assertStatus(422);
    }

    /**
     * Test checking a word with spaces.
     *
     * @return void
     */
    public function testCheckWordWithSpaces()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'word game']);
        $response->assertStatus(422);
    }

    /**
     * Test checking a Serbian word.
     *
     * @return void
     */
    public function testCheckSerbianWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'čokolada']);
        $response->assertStatus(422);
    }

    /**
     * Test checking multiple words in one request.
     *
     * @return void
     */
    public function testCheckMultipleWordsInOneRequest()
    {
        $response = $this->postJson('/api/check-word', ['words' => ['apple', 'banana']]);
        $response->assertStatus(422);
    }

    /**
     * Testing words that are anagrams of each other.
     *
     * @return void
     */
    public function testCheckAnagramWords()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'listen']);
        $response->assertStatus(200)
            ->assertJson(['score' => 6]);

        $response = $this->postJson('/api/check-word', ['word' => 'silent']);
        $response->assertStatus(200)
            ->assertJson(['score' => 6]);
    }

    /**
     * Testing processing of long words.
     *
     * @return void
     */
    public function testCheckLongWord()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'pneumonoultramicroscopicsilicovolcanoconiosis']);
        $response->assertStatus(200);
    }

    /**
     * Testing handling of different word variants.
     *
     * @return void
     */
    public function testCheckWordCaseInsensitive()
    {
        $response = $this->postJson('/api/check-word', ['word' => 'WORD']);
        $response->assertStatus(200)
            ->assertJson(['score' => 4]);
    }
}
