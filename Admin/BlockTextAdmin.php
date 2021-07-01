<?php

namespace HitcKit\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class BlockTextAdmin extends AbstractAdmin
{
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

    // protected function configureRoutes(RouteCollection $collection)
    // {
    //     if ($this->isChild()) {
    //         return;
    //     }
    //
    //     $collection->clear();
    // }

    public function getListModes()
    {
        unset($this->listModes['mosaic']);
        return parent::getListModes();
    }
}
