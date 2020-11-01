<?php

namespace HitcKit\CoreBundle\DependencyInjection;

use Exception;
use HitcKit\CoreBundle\Entity\Route;
use HitcKit\CoreBundle\Services\NodeTypeInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

class HitcKitCoreExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
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
            $container->prependExtensionConfig('cmf_routing', [
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
                            'route_class' => Route::class,
                        ],
                    ],
                ],
            ]);
        }

        if (isset($bundles['FOSCKEditorBundle'])) {
            $config = Yaml::parseFile(__DIR__.'/../Resources/config/fos_ck_editor.yaml');
            $container->prependExtensionConfig('fos_ck_editor', $config);
        }

        if (isset($bundles['SonataAdminBundle'])) {
            $container->loadFromExtension('sonata_admin', [
                'title' => 'Надежный IT сервис',
                'options' => ['title_mode' => 'single_text']
            ]);

            $container->prependExtensionConfig('framework', [
                'translator' => [
                    'paths' => [
                        realpath(__DIR__.'/../Resources/translations')
                    ]
                ]
            ]);
        }
    }
}
