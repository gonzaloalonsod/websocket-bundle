<?php

namespace RollandRock\WebsocketBundle\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use RollandRock\WebsocketBundle\Websocket;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
class ServerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rr:websocket:server')
            ->setDescription('Launches a websocket server.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $this->getContainer()->getParameter('rr_ws_port');
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    $this->getContainer()->get(Websocket::class)
                )
            ),
            $port
        );

        $output->writeln(sprintf('Launching a websocket server on port %d', $port));
        $server->run();
    }
}
