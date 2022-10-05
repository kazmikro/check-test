<?php

declare(strict_types=1);

namespace App\Exceptions;

class PageNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}
