<?php

namespace HitcKit\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use HitcKit\CoreBundle\Entity\Route as RouteOrm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('@HitcKitCore/home_page_not_defined.html.twig');
    }

    /**
     * @Route("/")
     * @param ChainRouterInterface $router
     * @param Request $request
     * @return Response
     */
    public function home(ChainRouterInterface $router, Request $request)
    {
        $route = $router->getRouteCollection()->get('home');

        $controller = $route
            ? (string)$route->getDefault(RouteOrm::CONTROLLER_NAME)
            : DefaultController::class.'::index'
        ;

        $request->attributes->set('_route', 'home');
        return $this->forward($controller, $request->attributes->all(), $request->query->all());
    }
}
