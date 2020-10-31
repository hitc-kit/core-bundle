<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use HitcKit\CoreBundle\Entity\Node;
use HitcKit\CoreBundle\Services\CoreType;
use HitcKit\CoreBundle\Services\NodeTypeManager;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\RequestStack;

class NodeCrudController extends AbstractCrudController
{
    protected $request;
    protected $nodeTypeManager;

    public function __construct(RequestStack $rStack, NodeTypeManager $nodeTypeManager)
    {
        $this->request = $rStack->getCurrentRequest();
        $this->nodeTypeManager = $nodeTypeManager;
    }

    public static function getEntityFqcn(): string
    {
        return Node::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        if (empty($this->request->query->get('nodeType'))) {
            $actions
                ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
                ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
                ->add(Crud::PAGE_NEW, Action::INDEX)
            ;
        } else {
            $crudUrlGenerator = $this->get(CrudUrlGenerator::class);
            $url = $crudUrlGenerator->build($this->request->query->all())->unset('nodeType')->generateUrl();
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

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        if (Crud::PAGE_NEW === $responseParameters->get('pageName')) {
            $responseParameters->set('nodeTypes', $this->nodeTypeManager->getTypesList());
        }

        return $responseParameters;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_NEW === $pageName) {
            $typeOptions = [
                'data' => $this->request->query->get('nodeType', CoreType::getName())
            ];

            return [
                FormField::addPanel('SEO'),
                TextField::new('type')
                    ->setFormType(HiddenType::class)
                    ->setFormTypeOptions($typeOptions)
                ,
                'title',
                'keywords',
                'description',
                FormField::addPanel('SECTION'),
                'heading',
                TextEditorField::new('content'),
                BooleanField::new('showInMenu')
                    ->setFormTypeOption('label_attr', ['class' => 'checkbox-custom'])
                ,
            ];
        } else {
            return parent::configureFields($pageName);
        }
    }
}
