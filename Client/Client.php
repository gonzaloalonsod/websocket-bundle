<?php

namespace RollandRock\WebsocketBundle\Client;

use Ratchet\ConnectionInterface;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
class Client implements ClientInterface
{
    /** @var ConnectionInterface */
    protected $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }
}
