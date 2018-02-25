<?php

namespace Beaver\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class BeaverCoreExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('beaver_core.contents', false);
        if ($config['contents']) {
            $container->setParameter('beaver_core.contents', $config['contents']);
        }

        $container->setParameter('beaver_core.layouts', false);
        if (false === is_null($config['layouts'])) {
            $container->setParameter('beaver_core.layouts', $config['layouts']);
        }
        
        $container->setParameter('beaver.blocks.directory', false);
	    if (false === is_null($config['blocks'])) {
		    $container->setParameter('beaver.blocks.directory', $config['blocks']);
	    }
    }
}
