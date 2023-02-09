<?php

declare(strict_types=1);

use Framework\Http\Message\ServerRequest;
use Framework\Http\Message\ServerResponse;

require __DIR__ . '/../vendor/autoload.php';

$request = ServerRequest::createFromGlobals();
$response = new ServerResponse('<h1>Hello</h1>');
$response->send();
