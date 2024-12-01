<?php

namespace Foamycastle\Event;

class EventDispatcher implements EventDispatcherApi
{

    /**
     *
     * @var EventDispatcherApi[]
     */
    private static array $dispatchers=[];
    /**
     * A collection of events the dispatcher is responsible for firing
     * @var EventApi[]
     */
    protected array $events = [];

    public function __construct(private string $id)
    {
        if(empty($events)) return;
        self::$dispatchers[$this->id]=$this;
    }
    public function __destruct()
    {
        if(isset(self::$dispatchers[$this->id])) {
            unset(self::$dispatchers[$this->id]);
        }
    }

    function hasEvent(string|Event $event): bool
    {
        if($event instanceof EventApi) {
            $event=$event->name;
        }
        return !empty(array_filter($this->events, fn($event)=>$event->name==$event));
    }

    function addEvent(...$events): void
    {
        foreach($events as $event) {
            if(!($event instanceof EventApi)) continue;
            $this->events[$event->name]=$event;
        }
    }

    function removeEvent(Event|string $event): void
    {
        if($event instanceof EventApi) {
            $event=$event->name;
        }
        unset($this->events[$event]);
    }
    public function dispatchEvent(Event|string $event, ...$args): mixed
    {
        if($event instanceof EventApi) {
            $event=$event->name;
        }
        return $this->events[$event]->dispatch(...$args);
    }

    function getEvents(): array
    {
        return $this->events;
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->hasEvent((string)$offset);
    }

    public function offsetGet(mixed $offset): ?EventApi
    {
        return $this->events[(string)$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if(!($value instanceof Event)) return;
        $this->events[(string)$offset]=$value;
    }

    public function offsetUnset(mixed $offset): void
    {
        if(!$this->hasEvent((string)$offset)) return;
        unset($this->events[(string)$offset]);
    }


    public static function __callStatic($name, $arguments):mixed
    {
        $name=strtolower($name);
        foreach(self::$dispatchers as $dispatcher) {
            if($dispatcher->hasEvent($name)) {
                $dispatcher->dispatchEvent($name);
            }
        }
        return null;
    }
}