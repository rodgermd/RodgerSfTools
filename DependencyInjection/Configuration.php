<?php

namespace Rodgermd\SfToolsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  /**
   * Generates the configuration tree.
   *
   * @return TreeBuilder
   */
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode    = $treeBuilder->root('rodgermd_sf_tools');

    $rootNode->children()
      ->arrayNode('directory_namer')->children()
      ->scalarNode('levels')->defaultValue(2)->end()
      ->scalarNode('length')->defaultValue(2)->end()
      ->end()
      ->end();

    return $treeBuilder;
  }
}
