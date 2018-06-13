<?php

namespace RollandRock\WebsocketBundle\Handler;

use Ratchet\ConnectionInterface;
use RollandRock\WebsocketBundle\Client\ClientStack;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
interface HandlerInterface
{
    public static function getName(): string;

    public function handle(ClientStack $clientStack, ConnectionInterface $connection, array $data);
}
