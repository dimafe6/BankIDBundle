<?php

namespace Dimafe6\BankIDBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class BankIDExtension.
 *
 * @category PHP
 *
 * @author   Dmytro Feshchenko <dimafe2000@gmail.com>
 */
class BankIDExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new  Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (null === $config['local_cert']) {
            $config['local_cert'] =
                $container->getParameter('kernel.project_dir').DIRECTORY_SEPARATOR.'vendor/dimafe6/bank-id/tests/bankId.pem';
        }

        if (!file_exists($config['local_cert'])) {
            throw new FileNotFoundException(null, 0, null, $config['local_cert']);
        }

        $options = ['local_cert' => $config['local_cert']];

        $options = array_merge($options, $config['soap_options']);

        $container->getDefinition('dimafe6.bankid')
            ->replaceArgument(0, $config['wsdl_url'])
            ->replaceArgument(1, $options)
            ->replaceArgument(2, $config['ssl'])
        ;
    }
}
