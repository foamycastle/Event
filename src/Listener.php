<?php

namespace Foamycastle\Event;

abstract class Listener implements ListenerApi
{

    /**
     * The event procedure
     * @var callable|null
     */
    private $callback;

    /**
     * The optional ID by which a listener may be known
     * @var string|null
     */
    private ?string $id;
    public function __construct(?callable $callback=null, ?string $id=null)
    {
        $this->callback = $callback;
        $this->id = $id;
    }
}