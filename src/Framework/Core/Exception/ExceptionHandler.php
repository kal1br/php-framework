<?php

declare(strict_types=1);

namespace Framework\Core\Exception;

use Exception;
use Framework\Http\Message\ServerResponse;

class ExceptionHandler
{
    private bool $production;

    public function __construct(bool $production = false)
    {
        $this->production = $production;
    }

    public function handle(Exception $e): ServerResponse
    {
        if (!$this->production) {
            $errorMessage = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();
            $trace = $e->getTraceAsString();

            $errorHtml = <<<HTML
                    <h1>{$errorMessage}</h1>
                    <p>File: {$file} (line {$line})</p>
                    <pre>{$trace}</pre>
                HTML;

            return new ServerResponse($errorHtml, 500);
        } else {
            $errorMessage = 'An error occurred while processing your request. Please try again later.';
            return new ServerResponse($errorMessage, 500);
        }
    }
}
