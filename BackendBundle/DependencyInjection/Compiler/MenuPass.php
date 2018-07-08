<?php
namespace Beaver\BackendBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MenuPass
 * @package Beaver\BackendBundle\DependencyInjection\Compiler
 */
class MenuPass implements CompilerPassInterface
{
    
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('beaver.wood.menu');
        
        $definition = $container->findDefinition('beaver.backend.menu');

        $container->getExtension('framework')->addAnnotatedClassesToCompile([
            'asd'
        ]);

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addWoodMenuService', [new Reference($id)]);
        }
    }
}
