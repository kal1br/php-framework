# PHP-FRAMEWORK

This native PHP framework is being created with the purpose of learning the language and the architecture of frameworks.

## Requirements

* Docker
* Make

## Commands

To run the project, use the following command:
```bash
make init
```

To run tests, use the following command:
```bash
make test
```

To stop the containers, use the following command:
```bash
make docker-down-clear
```

**you can find other commands in the Makefile**

## Usage

* Add route in file routes.php
```php
Router::get('/', 'example', 'index');
```

* Create a controller in folder /src/App/controllers
```php
<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Http\Response;

class ExampleController
{
    public function index(): void
    {
        $title = 'Добро пожаловать в наше приложение!';
        $description = 'Описание приложения и его возможностей';

        View::render('home/index.php', [
            'title' => $title,
            'description' => $description,
        ]);
    }
}
```

* Create template in folder /src/App/views
```php
<?php
declare(strict_types=1);
/**
 * @var $title string
 * @var $description string
 */
?>
<!doctype html>
<html lang="en">
<head>
    <title><?= $title ?></title>
</head>
<body>
    <h1><?= $title ?></h1>
    <p><?= $description ?></p>
</body>
</html>
```

## To be continued

Work on the framework is still ongoing, with plans to add new functionality and improve existing features. As updates are released, the documentation will be expanded accordingly.
