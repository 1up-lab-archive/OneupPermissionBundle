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
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->enumNode('adapter')
                            ->values(array('file', null))
                            ->defaultValue('file')
                        ->end()
                        ->scalarNode('directory')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
