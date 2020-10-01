<?php

namespace HitcKit\CoreBundle\DependencyInjection;

use App\Controller\DefaultController;
use App\Entity\Product;
use HitcKit\CoreBundle\Entity\RouteOrm;
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
                        'route_class' => RouteOrm::class,
                    ],
                ],
                'controllers_by_class' => [
                    Product::class => DefaultController::class.'::index'
                ],
            ],
        ];

        $container->prependExtensionConfig('cmf_routing', $config);

        if (!isset($bundles['DoctrineBundle'])) {
            return;
        }

        $config = [
            'orm' => [
                'entity_managers' => [
                    'default' => [
                        'mappings' => [
                            'HitcKitCoreBundle' => [
                                'type' => 'xml',
                                'dir' => 'Resources/config/doctrine-orm',
                                'prefix' => 'HitcKit\CoreBundle\Entity',
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
