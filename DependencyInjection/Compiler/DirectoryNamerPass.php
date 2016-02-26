<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 12.12.14
 * Time: 16:14.
 */

namespace Rodgermd\SfToolsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DirectoryNamerPass.
 */
class DirectoryNamerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $params = $container->getParameter('rodgermd_sftools', array());
        $service = $container->getDefinition('rodgermd.vichuploader.directory_name');
        if (isset($params['directory_namer'])) {
            $params = $params['directory_namer'];
            if (isset($params['length'])) {
                $service->addMethodCall('setLength', array($params['length']));
            }
            if (isset($params['levels'])) {
                $service->addMethodCall('setLevels', array($params['levels']));
            }
        }
    }
}
