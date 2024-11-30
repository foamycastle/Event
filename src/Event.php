<?php

namespace Foamycastle\Event;


/**
 * @property-read string $name
 */
abstract class Event implements EventApi
{

    /**
     * The list of callables associated with an event
     * @var array<string,callable>
     */
    protected array $callstack;

    public function __construct(
        private string $name
    ){
        $this->name = strtolower($name);
    }

    public function __get($name): mixed
    {
        return @match ($name) {
            'name' => $this->name,
            default => null,
        };
    }



}