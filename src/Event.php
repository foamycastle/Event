<?php

namespace Foamycastle\Event;


/**
 * @property-read string $name
 */
class Event implements EventApi
{

    /**
     * The list of callables associated with an event
     * @var callable[]
     */
    protected array $callstack;

    public function __construct(
        private string $name
    ){
    }

    public function __get($name): mixed
    {
        return @match ($name) {
            'name' => $this->name,
            default => null,
        };
    }

    public function __invoke(...$args): void
    {
        $this->dispatch(...$args);
    }


    function dispatch(...$args): void
    {
        foreach ($this->callstack as $call) {
            call_user_func_array($call, $args);
        }
    }

    function getListeners(): array
    {
        return $this->callstack ?? [];
    }

    function addListener(callable|ListenerApi $listener,?string $name=null): void
    {
        if($listener instanceof ListenerApi){
            $name=$listener->getId();
        }
        if(!is_null($name)){
            $this->callstack[$name] = $listener;
        }else {
            $this->callstack[] = $listener;
        }
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

    public function offsetExists(mixed $offset): bool
    {
        return $this->hasListener((string)$offset)!==null;
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->hasListener((string)$offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if(is_callable($value)){
            $this->addListener($value,$offset);
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->removeListener((string)$offset);
    }

    public function current(): mixed
    {
        return current($this->callstack);
    }

    public function next(): void
    {
        next($this->callstack);
    }

    public function key(): mixed
    {
        return current($this->callstack)->getId();
    }

    public function valid(): bool
    {
        return current($this->callstack)!==null;
    }

    public function rewind(): void
    {
        reset($this->callstack);
    }


}