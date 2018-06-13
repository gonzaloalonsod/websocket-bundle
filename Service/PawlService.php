<?php

namespace RollandRock\WebsocketBundle\Service;

use Psr\Log\LoggerInterface;

class PawlService
{
    private $logger;
    private $ws;
    private $res;

    public function __construct($port)
    {
        $this->ws = "ws://127.0.0.1:{$port}";
    }

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function sendMessage($type = null, $msg = null)
    {
        $this->res = false;

        \Ratchet\Client\connect($this->ws)->then(function($conn) use ($type, $msg) {
            $conn->send(json_encode(array("type" => $type, "data" => $msg)));
            $this->res = true;
            $conn->close();
        }, function ($e) {
            $this->logger->error("Could not connect: {$e->getMessage()}");
        });

        return $this->res;
    }
}