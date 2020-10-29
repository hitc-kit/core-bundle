<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use HitcKit\CoreBundle\Entity\Node;
use HitcKit\CoreBundle\Services\NodeTypeManager;

class NodeCrudController extends AbstractCrudController
{
    protected $nodeTypeManager;

    public function __construct(NodeTypeManager $nodeTypeManager)
    {
        $this->nodeTypeManager = $nodeTypeManager;
    }

    public static function getEntityFqcn(): string
    {
        return Node::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        if (empty($request->query->get('nodeType'))) {
            $actions
                ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
                ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
                ->add(Crud::PAGE_NEW, Action::INDEX)
            ;
        } else {
            $crudUrlGenerator = $this->get(CrudUrlGenerator::class);
            $url = $crudUrlGenerator->build($request->query->all())->unset('nodeType')->generateUrl();
            $action = Action::new('toTypeSelect', 'LINK_TO_NODE_TYPE_SELECT')->linkToUrl($url);
            $actions->add(Crud::PAGE_NEW, $action);
        }

        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/new', '@HitcKitCore/new_type_select.html.twig')
        ;
    }

    public function new(AdminContext $context)
    {
        return parent::new($context);
    }
}
