<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
                ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
                    return $action->addCssClass('btn');
                })
            ;
        } else {
            $crudUrlGenerator = $this->get(CrudUrlGenerator::class);
            $url = $crudUrlGenerator->build($this->request->query->all())->unset('nodeType')->generateUrl();
            $action = Action::new('toTypeSelect', 'LINK_TO_NODE_TYPE_SELECT')->linkToUrl($url)->addCssClass('btn');
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

            return [
                FormField::addPanel('SEO'),
                Field::new('type')
                    ->setFormType(HiddenType::class)
                    ->setFormTypeOptions([
                        'data' => $this->request->query->get('nodeType', CoreType::getName())
                    ])
                ,
                Field::new('title')
                    ->setFormTypeOptions([
                        'attr' => ['class' => 'mw-100'],
                    ])
                ,
                'keywords',
                'description',
                FormField::addPanel('SECTION'),
                'heading',
                Field::new('content')
                    ->setFormType(CKEditorType::class)
                    ->setFormTypeOptions([
                        'attr' => ['class' => 'mw-100'],
                    ])
                ,
                BooleanField::new('showInMenu')
                    ->setFormTypeOption('label_attr', ['class' => 'checkbox-custom'])
                ,
            ];
        } else {
            return parent::configureFields($pageName);
        }
    }
}
