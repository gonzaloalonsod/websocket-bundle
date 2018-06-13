<?php

namespace RollandRock\WebsocketBundle\Client;

use Ratchet\ConnectionInterface;
use RollandRock\WebsocketBundle\Exception\ClientNotFoundException;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
class ClientStack
{
    /** @var ClientInterface[] */
    private $clients = [];

    public function addClient(ClientInterface $client)
    {
        $this->clients[] = $client;
    }

    public function getClient(ConnectionInterface $connection): ClientInterface
    {
        return $this->clients[$this->getClientIndex($connection)];
    }

    public function removeClient(ConnectionInterface $connection)
    {
        unset($this->clients[$this->getClientIndex($connection)]);
    }

    public function getClients(): array
    {
        return $this->clients;
    }

    private function getClientIndex(ConnectionInterface $connection): int
    {
        foreach ($this->clients as $i => $c) {
            if ($c->getConnection() === $connection) {
                return $i;
            }
        }

        throw new ClientNotFoundException();
    }
}
