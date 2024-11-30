<?php

namespace Foamycastle\SoftError;

use Foamycastle\SoftError\Event;

class ErrorEvent extends Event
{

    public function __invoke(...$args): mixed
    {
        echo "Error. Priority=".$args[0]."\n";
        return null;
    }

}