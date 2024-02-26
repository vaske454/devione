<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiUrlValidatorTest extends TestCase
{
    /** @test */
    public function it_returns_200_for_valid_api_url()
    {
        config(['services.dictionary_api.url' => 'https://api.dictionaryapi.dev/api/v2/entries/en']);
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_500_for_empty_api_url()
    {
        config(['services.dictionary_api.url' => '']);
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_500_for_incorrect_api_url()
    {
        config(['services.dictionary_api.url' => 'https://example.com']);
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_500_for_api_url_not_matching_expected_url()
    {
        config(['services.dictionary_api.url' => 'https://api.dictionaryapi.dev/api/v2/entries/invalid']);
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_500_for_invalidly_formatted_api_url()
    {
        config(['services.dictionary_api.url' => 'not_a_valid_url']);
        $response = $this->postJson('/api/check-word', ['word' => 'level']);
        $response->assertStatus(500);
    }
}
