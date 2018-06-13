<?php

namespace RollandRock\WebsocketBundle;

use RollandRock\WebsocketBundle\DependencyInjection\Compiler\RegisterHandlersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RollandRockWebsocketBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterHandlersPass());
    }
}
