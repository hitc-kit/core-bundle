<?php

declare(strict_types=1);

namespace HitcKit\CoreBundle\Admin;

use HitcKit\CoreBundle\Entity\Block;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

final class BlockAdmin extends AbstractAdmin
{
    protected $translationDomain = 'HitcKitCoreBundle';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('area')
            ->add('name')
            ->add('priority')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('area')
            ->add('name')
            ->add('priority')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        // $this->setTemplate('edit', '@HitcKitCore/create_block.html.twig');

        $formMapper
            ->add('area')
            ->add('name')
            ->add('priority')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('area')
            ->add('name')
            ->add('priority')
        ;
    }

    public function getListModes()
    {
        unset($this->listModes['mosaic']);
        return parent::getListModes();
    }

    // protected function configureRoutes(RouteCollection $collection)
    // {
    //     if ($this->isChild()) {
    //         return;
    //     }
    //
    //     $collection->clear();
    // }

    public function toString($object)
    {
        return $object instanceof Block
            ? $object->getName()
            : $this->trans('block');
    }
}
