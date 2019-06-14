<?php

namespace AmorebietakoUdala\SMSServiceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/*
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */

class SMSServiceExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
//        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
//        $loader->load('services.xml');
//        $definition = $container->getDefinition('amorebietakoudala_smsservice.smssender');
//        $definition->setArgument(0, $configs[0]['username']);
//        $definition->setArgument(1, $configs[0]['password']);
//        $definition->setArgument(2, $configs[0]['account']);

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $definition = $container->getDefinition('AmorebietakoUdala\SMSServiceBundle\Controller\SmsSender');
        $definition->setArgument(0, $config['username']);
        $definition->setArgument(1, $config['password']);
        $definition->setArgument(2, $config['account']);
        $definition->setArgument(3, $config['test']);
    }
}
