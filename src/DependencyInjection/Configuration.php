<?php


namespace SymfonyLab\CustomerIOBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package SymfonyLab\CustomerIOBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('symfonylab_customer_io');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('site_id')->isRequired()->end()
            ->scalarNode('api_key')->isRequired()->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
