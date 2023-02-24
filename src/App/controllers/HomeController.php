<?php

declare(strict_types=1);

namespace App\controllers;

use Exception;
use Framework\View;

class HomeController
{
    /**
     * @throws Exception
     */
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
