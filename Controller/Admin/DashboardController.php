<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
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
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('HITc Corp.')

            // the path defined in this method is passed to the Twig asset() function
            // ->setFaviconPath('favicon.svg')
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            // MenuItem::linkToDashboard('DASHBOARD_HOME', 'fa fa-home'),

            MenuItem::section('MAIN'),
            MenuItem::linkToCrud('TREE', 'fa fa-tags', Node::class),
        ];
    }
}
