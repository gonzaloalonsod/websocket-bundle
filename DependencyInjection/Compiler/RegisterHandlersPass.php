<?php

namespace RollandRock\WebsocketBundle\DependencyInjection\Compiler;

use RollandRock\WebsocketBundle\Handler\HandlerRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Pierre Rolland <roll.pierre@gmail.com>
 */
class RegisterHandlersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(HandlerRegistry::class)) {
            return;
        }

        $registryDefinition = $container->findDefinition(HandlerRegistry::class);
        $handlers = $container->findTaggedServiceIds('websocket.handler');

        foreach ($handlers as $id => $handler) {
            $registryDefinition->addMethodCall('addHandler', [new Reference($id)]);
        }
    }
}
