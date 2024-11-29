<?php

namespace Foamycastle\SoftError;

class SoftErrorException extends \Exception
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('', 0, $previous);
    }

}