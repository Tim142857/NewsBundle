<?php

namespace Tleroch\NewsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface {

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tleroch_news');

        $rootNode
                ->children()
                ->scalarNode('news_class')
                ->isRequired()
                ->end()
                ->scalarNode('upload_folder')
                ->isRequired()
                ->end()
                ->scalarNode('news_type')
                ->defaultValue('Tleroch\NewsBundle\Form\NewsType')
                ->end()
                ->end()
        ;

        return $treeBuilder;
    }

}
