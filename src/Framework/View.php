<?php

declare(strict_types=1);

namespace Framework;

use Exception;

class View
{
    /**
     * Отображает представление
     *
     * @param string $view Путь к файлу представления
     * @param array $data Ассоциативный массив данных для передачи в представление
     * @throws Exception
     */
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        $file = __DIR__ . "/../App/views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new Exception("Файл представления $file не найден");
        }
    }
}
