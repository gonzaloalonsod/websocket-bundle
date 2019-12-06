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

    protected $memcached;
    protected $memcachedPrefix;
    protected $memcachedExpire;

    public function __construct($memcachedHost, $memcachedPort, $memcachedPrefix, $memcachedExpire) {
        $this->memcachedPrefix = $memcachedPrefix;
        $this->memcachedExpire = $memcachedExpire;
        $this->memcached = new \Memcached();
        $this->memcached->addServer($memcachedHost, $memcachedPort);

        $this->getMemcached();
    }

    public function addClient(ClientInterface $client)
    {
        $this->clients[] = $client;
        $this->replaceMemcached();
    }

    public function getClient(ConnectionInterface $connection): ClientInterface
    {
        return $this->clients[$this->getClientIndex($connection)];
    }

    public function removeClient(ConnectionInterface $connection)
    {
        unset($this->clients[$this->getClientIndex($connection)]);
        $this->replaceMemcached();
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

    private function getMemcached()
    {
        $clients = $this->memcached->get($this->memcachedPrefix.'rr_clients', null);
        if ($clients) {
            $this->clients = $clients;
        } else {
            $this->memcached->add(
                $this->memcachedPrefix.'rr_clients', $this->clients, $this->memcachedExpire
            );
        }
    }
    private function replaceMemcached()
    {
        $this->memcached->replace(
            $this->memcachedPrefix.'rr_clients', $this->clients, $this->memcachedExpire
        );
    }
}
