<?php

namespace Foamycastle\Event;

abstract class EventDispatcher implements EventDispatcherApi
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

    public function __construct(?array $events = null)
    {
        $this->events = $events ?? [];
    }

    static function hasEvent(string|Event $event): bool
    {
        if($event instanceof EventApi) {
            $event=$event->name;
        }
        return isset(self::$dispatchers[$event]);

    }
    public static function __callStatic($name, $arguments):mixed
    {
        $name=strtolower($name);
        if(!self::hasEvent($name)) return null;
        $events=self::$dispatchers[$name]->getEvents();
        if(is_string($arguments)){
            $arguments=[$arguments];
        }
        $arguments=array_filter($arguments,fn($arg)=>is_string($arg));
        $eventsToDispatch=array_filter($events, fn($event)=>in_array($event->getName(),$arguments));

        return (match(strtolower($name)) {
            'async'=>function (...$arguments) use ($eventsToDispatch) {
                while(current($eventsToDispatch)!==false) {
                    current($eventsToDispatch)->dispatchAsync(...$arguments);
                    next($eventsToDispatch);
                }
            },
            'sync'=>function (...$arguments) use ($eventsToDispatch) {
                while(current($eventsToDispatch)!==false) {
                    current($eventsToDispatch)->dispatch(...$arguments);
                    next($eventsToDispatch);
                }
            },
            default=>fn()=>null
        })();
    }
}