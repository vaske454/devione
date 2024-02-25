<?php

namespace App\Console\Commands;

use App\Http\Controllers\WordGameController;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

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
            $response = $this->wordGameController->checkWord(new Request(['word' => $word]));

            // Output the result
            $this->info($response->getContent());
        } catch (Exception $e) {
            // Output the exception message in red color
            $this->error($e->getMessage());
        }
    }
}
