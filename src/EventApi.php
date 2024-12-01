<?php

namespace Foamycastle\Event;

use Reflector;

interface EventApi extends \ArrayAccess, \Iterator
{
    public function __invoke(...$args):void;

    /**
     * Fire a blocking event
     * @param ...$args
     * @return mixed
     */
    function dispatch(...$args):void;

    /**
     * Return an array of Listeners
     * @return array<string,ListenerApi>
     */
    function getListeners():array;

    /**
     * Add a listener to the stack
     * @param ListenerApi $listener The callback function
     * @return void
     */
    function addListener(ListenerApi $listener):void;

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
     * @return ListenerApi|null returns the object if the ID is found, null if it is not
     */
    function hasListener(string $id):null|ListenerApi;

}