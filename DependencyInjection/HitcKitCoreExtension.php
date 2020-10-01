<?php

namespace HitcKit\CoreBundle\DependencyInjection;

use Symfony\Cmf\Bundle\RoutingBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class HitcKitCoreExtension extends Extension implements PrependExtensionInterface
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // $loader->load('common.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['CmfRoutingBundle'])) {
            return;
        }

        $configs = $container->getExtensionConfig('cmf_routing');
        $config = $this->processConfiguration(new Configuration(), $configs);
        // $config['dynamic']['controllers_by_class'];
    }
}
