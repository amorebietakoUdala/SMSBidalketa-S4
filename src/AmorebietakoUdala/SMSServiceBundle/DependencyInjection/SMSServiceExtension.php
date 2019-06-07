<?php

namespace App\AmorebietakoUdala\SMSServiceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
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
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $definition = $container->getDefinition('App\AmorebietakoUdala\SMSServiceBundle\Controller\SmsSender');
        $definition->replaceArgument('$username', $config['username']);
        $definition->replaceArgument('$password', $config['password']);
        $definition->replaceArgument('$account', $config['account']);
//        dump($definition);
//        die;
//        $definition->setArgument('$password', new Reference($config['password']));
//        $definition->setArgument('$account', new Reference($config['account']));
//        $definition->replaceArgument('$username', $config['username']);
//        $definition->replaceArgument('$password', $config['password']);
//        $definition->replaceArgument('$account', $config['account']);
    }
}
