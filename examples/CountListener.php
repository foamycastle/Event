<?php

namespace Foamycastle\Event\Example;

use Foamycastle\Event\Listener;

class CountListener extends Listener
{

    public function __construct()
    {
        parent::__construct(null, 'divide by 10');
    }

    /**
     * @inheritDoc
     */
    function __invoke(...$args): mixed
    {
        echo "count has reached: ".($args[0] ?? '')."\n";
        return null;
    }

}