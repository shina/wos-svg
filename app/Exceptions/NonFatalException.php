<?php

namespace App\Exceptions;

use Exception;

class NonFatalException extends Exception
{
    public function report(): void
    {
        info($this->getMessage(), ['trace' => $this->getTraceAsString()]);
    }
}
