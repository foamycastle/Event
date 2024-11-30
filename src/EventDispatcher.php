<?php

namespace Foamycastle\SoftError;

class EventDispatcher
{
    /**
     * @var array<array-key,array<array-key,Event>>
     */
    protected array $listeners = [];
    public function __construct()
    {
    }
    public function addListener(string $name, callable|Event $listener,int $priority=0):void
    {
        if($priority<0) $priority=0;
        $this->listeners[$name][$priority][]=$listener;
        ksort($this->listeners[$name]);
    }

    public function removeListener(string $name):void
    {
        if (isset($this->listeners[$name])) {
            unset($this->listeners[$name]);
        }
    }

    public function dispatch(string $event,...$args):void
    {
        foreach ($this->listeners[$event] as $priority=>$priorityLevel) {
            foreach ($priorityLevel as $listener) {
                $listener($priority);
            }
        }
    }
}