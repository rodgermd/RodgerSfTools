<?php


namespace Rodgermd\SfToolsBundle;

use Rodgermd\SfToolsBundle\DependencyInjection\Compiler\TwigResourcePass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RodgermdSfToolsBundle extends Bundle
{
  public function build(ContainerBuilder $container)
  {
    parent::build($container);

    $container->addCompilerPass(new TwigResourcePass());
  }
}
