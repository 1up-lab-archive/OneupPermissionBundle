<?php

namespace Oneup\PermissionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OneupPermissionExtension extends Extension
{
    protected $storageServices = array();

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.xml');
        $loader->load('metadata.xml');

        $container->setParameter('oneup_permission.masks', $config['masks']);

        $this->handleCacheConfiguration($container, $loader, $config['cache']);
    }

    protected function handleCacheConfiguration(ContainerBuilder $container, LoaderInterface $loader, array $config)
    {
        if (!$config['enabled']) {
            return;
        }

        // set to default cache directory
        if (is_null($config['directory'])) {
            $config['directory'] = $container->getParameter('kernel.cache_dir');
        }

        $container->setParameter('oneup_permission.cache', $config);
        $container->setParameter('oneup_permission.cache_dir', $config['directory']);

        // load cache services ...
        $loader->load('cache.xml');

        // ... and alias it
        $container->setAlias('oneup_permission.cache', new Alias(sprintf('oneup_permission.cache.%s', $config['adapter'])));

        // set cache to MetadataFactory
        $factory = $container->get('oneup_permission.metadata.factory');
        $factory->setCache($container->get('oneup_permission.cache'));
    }
}
