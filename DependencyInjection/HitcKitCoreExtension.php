<?php

namespace HitcKit\CoreBundle\DependencyInjection;

use Exception;
use HitcKit\CoreBundle\Services\NodeTypeInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\Yaml\Yaml;

class HitcKitCoreExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function loadInternal(array $config, ContainerBuilder $container)
    {
        $container
            ->registerForAutoconfiguration(NodeTypeInterface::class)
            ->addTag('hitckit_core.node_type')
        ;

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['CmfRoutingBundle'])) {
            $config = Yaml::parseFile(__DIR__.'/../Resources/config/cmf_routing.yaml');
            $container->prependExtensionConfig('cmf_routing', $config);
        }

        if (isset($bundles['FOSCKEditorBundle'])) {
            $config = Yaml::parseFile(__DIR__.'/../Resources/config/fos_ckeditor.yaml');
            $container->prependExtensionConfig('fos_ck_editor', $config);
        }

        if (isset($bundles['TwigBundle'])) {
            $config = Yaml::parseFile(__DIR__.'/../Resources/config/twig.yaml');
            $container->prependExtensionConfig('twig', $config);
        }

        if (isset($bundles['HitcKitAdminBundle'])) {
            $config = Yaml::parseFile(__DIR__.'/../Resources/config/hitc_kit_admin.yaml');
            $container->prependExtensionConfig('hitc_kit_admin', $config);
        }
    }
}
