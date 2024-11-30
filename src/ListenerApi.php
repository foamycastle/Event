<?php

namespace Foamycastle\Event;

interface ListenerApi
{

    /**
     * Invoke the action contained in the listener object
     * @param ...$args
     * @return mixed
     */
    function __invoke(...$args):mixed;
}