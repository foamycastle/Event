<?php

namespace Foamycastle\SoftError;

use Foamycastle\SoftError\Event;

class ExceptionEvent extends Event
{

    public function __invoke(): mixed
    {
        echo "Error";
        print_r(...func_get_args());
        return null;
    }

}