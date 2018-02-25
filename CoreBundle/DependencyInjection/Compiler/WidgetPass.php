<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/18/17
 * Time: 09:09
 */
namespace Beaver\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class WidgetPass
 * @package Beaver\CoreBundle\DependencyInjection\Compiler
 */
class WidgetPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('beaver.core.widget')) {
            throw new Exception('No esta definido WidgetService. Fijate de definirlo en los servicios de Core.');
        }

        $widgetService = $container->findDefinition('beaver.core.widget');

        foreach ($container->findTaggedServiceIds('beaver.widget') as $id => $tags) {
            $widgetService->addMethodCall('addWidget', [$id, new Reference($id)]);
        }
    }
}