<?php

namespace Rodgermd\SfToolsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TwigResourcePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $res = 'RodgermdSfToolsBundle:Form:fields.html.twig';
        if (!$container->hasParameter('twig.form.resources')) {
            $container->setParameter('twig.form.resources', array($res));
        } else {
            $resources = $container->getParameter('twig.form.resources');
            $resources[] = $res;
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
