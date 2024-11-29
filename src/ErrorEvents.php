<?php

namespace Foamycastle\SoftError;

use Throwable;

class ErrorEvents
{

    /**
     * A list of events to call upon certain
     * @var list<class-string,callable[]>
     */
    static $events = [];
    static bool $listening = false;
    private static $previousCallable=null;

    /**
     * @param Throwable $error
     * @param callable $listener
     * @return void
     */
    public static function addErrorListener(Throwable $error, callable $listener):void
    {
        self::$events[$error::class][] = $listener;
    }
    public static function removeListener(Throwable $error):void
    {
        if(isset(self::$events[$error::class])) {
            unset(self::$events[$error::class]);
        }
    }
    public static function dispatch(Throwable $error):void
    {
        if(isset(self::$events[$error::class])) {
            foreach(self::$events[$error::class] as $listener) {
                $listener($error);
            }
        }
    }
    public static function Listen(bool $listen):void
    {

        self::$listening = $listen;
        if(!$listen) {
            set_exception_handler(self::$previousCallable);
        }else{
            set_exception_handler([self::class, 'dispatch']);
        }
    }

}