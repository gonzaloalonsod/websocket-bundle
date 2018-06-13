<?php

namespace RollandRock\WebsocketBundle\Handler;

use RollandRock\WebsocketBundle\Exception\HandlerNotFoundException;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
class HandlerRegistry
{
    /** @var HandlerInterface[] */
    private $handlers = [];

    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[$handler::getName()] = $handler;
    }

    public function getHandler(string $name): HandlerInterface
    {
        if (isset($this->handlers[$name])) {
            return $this->handlers[$name];
        }

        throw new HandlerNotFoundException(sprintf('Handler %s not found', $name));
    }
}
