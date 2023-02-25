<?php

declare(strict_types=1);

namespace App\controllers;

use Exception;
use Framework\Http\Message\ServerResponse;
use Framework\Core\View;

class HomeController
{
    /**
     * @throws Exception
     */
    public function index(): ServerResponse
    {
        $title = 'Добро пожаловать в наше приложение!';
        $description = 'Описание приложения и его возможностей';

        return View::render('home/index.php', [
            'title' => $title,
            'description' => $description,
        ]);
    }
}
