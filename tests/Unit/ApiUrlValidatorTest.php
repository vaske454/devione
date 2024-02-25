<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiUrlValidatorTest extends TestCase
{
    /** @test */
    public function it_returns_200_for_valid_api_url()
    {
        // Arrange
        config(['services.dictionary_api.url' => 'https://api.dictionaryapi.dev/api/v2/entries/en']);

        // Act
        $response = $this->postJson('/api/check-word', ['word' => 'level']);

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_500_for_empty_api_url()
    {
        // Arrange
        config(['services.dictionary_api.url' => '']);

        // Act
        $response = $this->postJson('/api/check-word', ['word' => 'level']);

        // Assert
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_500_for_incorrect_api_url()
    {
        // Arrange
        config(['services.dictionary_api.url' => 'https://example.com']);

        // Act
        $response = $this->postJson('/api/check-word', ['word' => 'level']);

        // Assert
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_500_for_api_url_not_matching_expected_url()
    {
        // Arrange
        config(['services.dictionary_api.url' => 'https://api.dictionaryapi.dev/api/v2/entries/invalid']);

        // Act
        $response = $this->postJson('/api/check-word', ['word' => 'level']);

        // Assert
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_500_for_invalidly_formatted_api_url()
    {
        // Arrange
        config(['services.dictionary_api.url' => 'not_a_valid_url']);

        // Act
        $response = $this->postJson('/api/check-word', ['word' => 'level']);

        // Assert
        $response->assertStatus(500);
    }
}
