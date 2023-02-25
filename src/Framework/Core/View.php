<?php

declare(strict_types=1);

namespace Framework\Core;

use Exception;
use Framework\Http\Message\ServerResponse;

class View
{
    /**
     * Отображает представление
     *
     * @param string $view Путь к файлу представления
     * @param array $data Ассоциативный массив данных для передачи в представление
     * @throws Exception
     */
    public static function render(string $view, array $data = []): ServerResponse
    {
        extract($data);

        $file = __DIR__ . "/../../App/views/$view";

        if (is_readable($file)) {
            ob_start();
            require $file;
            $html = ob_get_clean();
            return new ServerResponse($html);
        } else {
            throw new Exception("Файл представления $file не найден");
        }
    }
}
