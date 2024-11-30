<?php

namespace Foamycastle\SoftError;

abstract class Event
{
    public function __construct(
        string $name,
    )
    {
        $this->name = $name;
    }

    public function getName():string
    {
        return $this->name;
    }

    abstract public function __invoke():mixed;

}