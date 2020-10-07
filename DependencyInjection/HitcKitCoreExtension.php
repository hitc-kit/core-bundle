<?php

namespace HitcKit\CoreBundle\DependencyInjection;

use Exception;
use HitcKit\CoreBundle\Entity\Node;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HitcKitCoreExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['CmfRoutingBundle'])) {
            $config = [
                'chain' => [
                    'routers_by_id' => [
                        'router.default' => 200,
                        'cmf_routing.dynamic_router' => 100,
                    ],
                ],
                'dynamic' => [
                    'persistence' => [
                        'orm' => [
                            'enabled' => true,
                            'route_class' => Node::class,
                        ],
                    ],
                ],
            ];

            $container->prependExtensionConfig('cmf_routing', $config);
        }

        if (isset($bundles['DoctrineBundle'])) {
            $config = [
                'orm' => [
                    'entity_managers' => [
                        'default' => [
                            'mappings' => [
                                'HitcKitCoreBundle' => [
                                    'type' => 'xml',
                                    'dir' => 'Resources/config/doctrine-orm',
                                    'prefix' => 'HitcKit\\CoreBundle\\Entity',
                                    'alias' => 'hitc_kit_core',
                                    'is_bundle' => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ];

            $container->prependExtensionConfig('doctrine', $config);
        }
    }
}
