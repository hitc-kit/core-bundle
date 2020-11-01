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
            ->addTag('hitc_kit_core.node_type')
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
            $container->prependExtensionConfig('fos_ck_editor', [
                'default_config' => 'default',
                'configs' => [
                    'default' => [
                        'height' => 350,
                        'allowedContent' => true,
                        'format_tags' => 'p;h2;h3;h4;h5;h6;pre;address;div',
                        'toolbarGroups' => [
                            ['name' => 'document', 'groups' => ['mode', 'tools', 'document', 'doctools']],
                            [ 'name' => 'clipboard', 'groups' => [ 'clipboard', 'cleanup', 'undo' ] ],
                            [ 'name' => 'editing', 'groups' => [ 'find', 'selection', 'spellchecker', 'editing' ] ],
                            '/',
                            [ 'name' => 'paragraph', 'groups' => [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] ],
                            [ 'name' => 'links', 'groups' => [ 'links' ] ],
                            [ 'name' => 'insert', 'groups' => [ 'insert' ] ],
                            '/',
                            [ 'name' => 'basicstyles', 'groups' => [ 'basicstyles' ] ],
                            [ 'name' => 'styles', 'groups' => [ 'styles' ] ],
                            [ 'name' => 'colors', 'groups' => [ 'colors' ] ],
                            [ 'name' => 'others', 'groups' => [ 'others' ] ],
                            [ 'name' => 'about', 'groups' => [ 'about' ] ],
                        ],
                        'removeButtons' => 'BidiLtr,BidiRtl,Language,Scayt,Flash,Smiley,Iframe,Styles',
                    ],
                ],
            ]);
        }
    }
}
