<?php

namespace Oneup\PermissionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('oneup_permission');

        $rootNode
            ->children()
                ->arrayNode('masks')
                    ->prototype('scalar')->end()
                    ->defaultValue(array('VIEW', 'EDIT', 'DELETE'))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
