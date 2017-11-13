<?php

namespace Dimafe6\BankIDBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @category PHP
 *
 * @author   Dmytro Feshchenko <dimafe2000@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $wsdlCacheArray = [
            'none' => WSDL_CACHE_NONE,
            'disk' => WSDL_CACHE_DISK,
            'memory' => WSDL_CACHE_MEMORY,
            'both' => WSDL_CACHE_BOTH,
        ];

        $soapVersions = [
            '1.1' => SOAP_1_1,
            '1.2' => SOAP_1_2,
        ];

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bank_id')->isRequired()->cannotBeEmpty();

        $rootNode
            ->children()
                ->scalarNode('wsdl_url')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('ssl')->isRequired()->defaultFalse()->end()
                ->scalarNode('local_cert')
                    ->defaultValue(null)
                    ->beforeNormalization()
                        ->ifTrue(function ($v) {
                            return !file_exists($v);
                        })
                        ->thenInvalid('Local certificate in path %s not found')
                    ->end()
                ->end()
                ->arrayNode('soap_options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('soap_version')
                            ->defaultValue('1.2')
                            ->beforeNormalization()
                                ->ifNotInArray(array_keys($soapVersions))
                                ->thenInvalid('Invalid SOAP version. The soap_version option should be one of either 1_1 or 1_2 to select SOAP 1.1 or 1.2, respectively. If omitted, 1_1 is used')
                                ->ifInArray(array_keys($soapVersions))
                                ->then(function ($value) use ($soapVersions) {
                                    return $soapVersions[$value];
                                })
                            ->end()
                        ->end()
                        ->booleanNode('compression')->defaultFalse()->end()
                        ->booleanNode('trace')->defaultFalse()->end()
                        ->integerNode('connection_timeout')->defaultValue(60)->end()
                        ->scalarNode('cache_wsdl')
                            ->defaultValue('none')
                            ->beforeNormalization()
                                ->ifNotInArray(array_keys($wsdlCacheArray))
                                ->thenInvalid('Invalid WSDL cache option. The cache_wsdl option should be one of either none, disk, memory or both. If omitted, none is used')
                                ->ifInArray(array_keys($wsdlCacheArray))
                                ->then(function ($value) use ($wsdlCacheArray) {
                                    return $wsdlCacheArray[$value];
                                })
                            ->end()
                        ->end()
                        ->scalarNode('user_agent')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
