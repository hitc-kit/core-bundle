<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use HitcKit\CoreBundle\Entity\Node;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/a-h767323")
     */
    public function index(): Response
    {
        // return parent::index();
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(NodeCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Надежный IT сервис')
            ->setTranslationDomain('HitcKitCoreBundle')
            ->setFaviconPath('/bundles/hitckitcore/favicon.ico')
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            // MenuItem::linkToDashboard('DASHBOARD_HOME', 'fa fa-home'),

            MenuItem::section('MAIN'),
            MenuItem::linkToCrud('TREE', 'fa fa-sitemap', Node::class),
        ];
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }


}
