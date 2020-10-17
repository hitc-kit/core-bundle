<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use HitcKit\CoreBundle\Entity\Node;

class NodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Node::class;
    }
}
