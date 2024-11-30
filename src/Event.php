<?php

namespace Foamycastle\Event;


/**
 * @property-read string $name
 */
abstract class Event implements EventApi
{

    /**
     * The list of callables associated with an event
     * @var ListenerApi[]
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

    function dispatch(...$args): void
    {
        foreach($this->getListeners() as $listener) {
            $listener(...$args);
        }
    }

    function getListeners(): array
    {
        return $this->callstack ?? [];
    }

    function addListener(ListenerApi $listener): void
    {
        $this->callstack[] = $listener;
    }

    function removeListener(string $id): void
    {
        $unset=false;
        foreach($this->callstack as $listener){
            if($listener->getId() === $id) unset($listener);
            $unset=true;
        }
        if($unset){
            $this->callstack = array_filter($this->callstack, fn($l) => !empty($l));
        }
    }

    function hasListener(string $id): null|ListenerApi
    {
        foreach ($this->callstack as &$listener) {
            if ($listener->getId() === $id) return $listener;
        }
        return null;
    }


}