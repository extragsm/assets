<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Extragsm\Assets\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * A representation of config.yml
 *
 * @author razvandubau
 */
class AssetsConfigurationBuilder implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('assets');

        $rootNode
            ->children()
                ->arrayNode('paths')
                    ->info("This will help you to simplify the config for every assets by not having to specify the entire path of every asset.")
                    ->children()
                        ->scalarNode('extended')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('destination')
                            ->defaultNull()
                        ->end()
                    ->end()
                    ->addDefaultsIfNotSet()
                ->end()
                ->variableNode('groups')
                    ->isRequired()
                ->end()
            ->end()
        ;
        
        return $treeBuilder;
    }
}
