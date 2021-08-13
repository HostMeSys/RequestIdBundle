<?php

/*
 * This file is part of the RequestIdBundle package.
 * (c) HostMe <contact@hostme.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HostMe\RequestIdBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('hostme_request_id');

        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('enable')->defaultTrue()->end()
                ->booleanNode('enable_monolog')->defaultTrue()->end()
                ->booleanNode('trust_request_header')->defaultTrue()->end()
                ->scalarNode('response_header')->cannotBeEmpty()->defaultValue('X-Request-Id')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
