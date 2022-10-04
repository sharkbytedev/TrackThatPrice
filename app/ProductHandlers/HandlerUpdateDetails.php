<?php

namespace App\ProductHandlers;

use Exception;

class HandlerUpdateDetails
{
    protected bool $successful;

    protected Exception $exception;

    public function __construct(bool $successful, Exception $exception = null)
    {
        $this->successful = $successful;
        $this->exception = $exception;
    }

    public function is_successful()
    {
        return $this->successful;
    }

    public function get_exception()
    {
        return $this->exception;
    }
}
