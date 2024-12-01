<?php

namespace Foamycastle\Event;

interface EventDispatcherApi extends \ArrayAccess
{

    /**
     * Add an event
     * @param Event[] $events
     * @return void
     */
    function addEvent(...$events):void;
    function removeEvent(Event|string $event):void;
    function hasEvent(Event|string $event):bool;
    function dispatchEvent(Event|string $event):mixed;
    function getEvents():array;

}