<?php

declare(strict_types=1);

use function Framework\Http\createServerRequestFromGlobals;

require __DIR__ . '/../vendor/autoload.php';

$request = createServerRequestFromGlobals();

echo '<pre>';
var_dump($request->getHeaders());
echo '</pre>';
