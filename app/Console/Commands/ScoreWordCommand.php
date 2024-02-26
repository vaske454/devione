<?php

namespace App\Console\Commands;

use App\Http\Controllers\WordGameController;
use Exception;
use Illuminate\Console\Command;

class ScoreWordCommand extends Command
{
    protected $signature = 'score:word {word}';
    protected $description = 'Calculate score for a word';

    protected WordGameController $wordGameController;

    public function __construct(WordGameController $wordGameController)
    {
        parent::__construct();
        $this->wordGameController = $wordGameController;
    }

    public function handle(): void
    {
        $word = $this->argument('word');

        try {
            // Call the controller method to handle the word
            $response = $this->wordGameController->checkWordCommand($word);

            // Output the result
            $this->info($response->getContent());
        } catch (Exception $e) {
            // Output the exception message in red color
            $errorMessage = $e->getMessage();
            // Extracting title from the error message
            // Check if the error message contains a title
            if (str_contains($errorMessage, '"title"')) {
                // Extracting title from the error message
                preg_match('/"title":"([^"]+)"/', $errorMessage, $matches);
                $title = $matches[1] ?? 'Unknown error occurred';
            } else {
                // If no title found, use the full error message
                $title = $errorMessage;
            }

            // Output the extracted title
            $this->error($title);
        }
    }
}
