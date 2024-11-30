<?php

namespace Foamycastle\Event;

use Reflector;

interface EventApi extends \ArrayAccess, \Iterator
{

    /**
     * Fire a blocking event
     * @param ...$args
     * @return void
     */
    function dispatch(...$args):void;

    /**
     * Fire a non-blocking event
     * @param ...$args
     * @return void
     */
    function dispatchAsync(...$args):void;
    /**
     * Return an array of Listeners
     * @return array<string,ListenerApi>
     */
    function getListeners():array;

    /**
     * Add a listener to the stack
     * @param ListenerApi $listener The callback function
     * @param string|null $id An optional ID if the listener will need to be removed at a later time
     * @return void
     */
    function addListener(ListenerApi $listener, ?string $id=null):void;

    /**
     * Remove a listener from the call stack.  If the listener was not added with an ID,
     * it will not be able to be removed
     * @param string $id The ID of the callback function
     * @return void
     */
    function removeListener(string $id):void;

    /**
     * Indicate that a listener's ID is present in the call stack
     * @param string $id The ID of the callback function
     * @return bool TRUE if the ID exists in the call stack
     */
    function hasListener(string $id):bool;

}