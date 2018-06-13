<?php

namespace RollandRock\WebsocketBundle\Client;

use Ratchet\ConnectionInterface;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
interface ClientInterface
{
    public function getConnection(): ConnectionInterface;
}
