<?php

namespace App\Controllers;

use App\Contracts\ControllerInterface;
use Exception;

class BaseController implements ControllerInterface
{
    public function beforeAction(): void
    {
    }

    /**
     * @throws Exception
     */
    public function redirect(string $path): void
    {
        if (empty($path)) {
            throw new Exception('Path is empty.');
        }
        header('Location: ' . $path);
    }
}
