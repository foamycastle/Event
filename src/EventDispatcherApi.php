<?php

namespace Foamycastle\Event;

interface EventDispatcherApi
{

    /**
     * Add an event
     * @param Event $event
     * @return void
     */
    function addEvent(Event $event):void;
    function removeEvent(Event|string $event):void;
    function getEvents():array;

}