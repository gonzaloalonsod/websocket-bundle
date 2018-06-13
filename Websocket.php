<?php

namespace RollandRock\WebsocketBundle;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use RollandRock\WebsocketBundle\Client\ClientStack;
use RollandRock\WebsocketBundle\Handler\HandlerRegistry;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
class Websocket implements MessageComponentInterface
{
    /** @var ClientStack */
    private $clientStack;

    /** @var HandlerRegistry */
    private $handlerRegistry;

    /** @var string */
    private $clientClass;

    public function __construct(HandlerRegistry $handlerRegistry, string $clientClass)
    {
        $this->clientStack = new ClientStack();
        $this->handlerRegistry = $handlerRegistry;
        $this->clientClass = $clientClass;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clientStack->addClient(new $this->clientClass($conn));
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg, true);
        $this->handlerRegistry->getHandler($msg['type'])->handle($this->clientStack, $from, $msg['data']);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clientStack->removeClient($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->onClose($conn);
        $conn->close();
    }
}
