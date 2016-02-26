<?php

namespace Rodgermd\SfToolsBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Class RodgermdSfToolsExtension.
 */
class RodgermdSfToolsExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('services') as $basename) {
            $loader->load(sprintf('%s.yml', $basename));
        }

        if (count($configs)) {
            $container->setParameter('rodgermd_sftools', reset($configs));
        }
    }
}
