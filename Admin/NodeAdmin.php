<?php

declare(strict_types=1);

namespace HitcKit\CoreBundle\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use HitcKit\CoreBundle\Entity\Node;
use Sonata\AdminBundle\Admin\AdminInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;

final class NodeAdmin extends AbstractAdmin
{
    protected $translationDomain = 'HitcKitCoreBundle';

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['header_style' => 'padding-right: 15px;'])
            ->add('name', null, ['header_style' => 'width: 35%;'])
            ->add('title', null, ['header_style' => 'width: 65%;'])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                ]
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $this->label = 'node';

        $formMapper
            ->add('name', null, ['required' => true])
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('content', CKEditorType::class, ['required' => false])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('type')
            ->add('name')
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('content')
            ->add('showInMenu')
            ->add('priority')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('show')
            ->remove('delete')
        ;
    }

    protected function configureTabMenu(MenuItemInterface $menu, $action, ?AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        if ($this->isGranted('EDIT')) {
            $menu->addChild('Node Edit', $admin->generateMenuUrl('edit', ['id' => $id]));
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('Block List', $admin->generateMenuUrl('hitc_kit_core.admin.block.list', ['id' => $id]));
        }

        if ($childAdmin && $childAdmin->getCurrentChild()) {
            // $childAdmin->getCurrentChildAdmin()->
            // $childId = $admin->getRequest()->get('childId');
            // $see = $admin->generateMenuUrl('hitc_kit_core.admin.block_text.list', ['id' => $id, 'childId' => $childId]);
            //
            // if ($childId) {
            //     $menu->addChild('Block Text List', $admin->generateMenuUrl('hitc_kit_core.admin.block|hitc_kit_core.admin.block_text.list', ['id' => $id, 'childId' => $childId]));
            // }
        }
    }

    public function getExportFormats()
    {
        return [];
    }

    public function toString($object)
    {
        return $object instanceof Node
            ? $object->getName()
            : $this->trans('node');
    }

    public function getListModes()
    {
        unset($this->listModes['mosaic']);
        return parent::getListModes();
    }
}
