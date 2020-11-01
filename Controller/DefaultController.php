<?php

namespace HitcKit\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use HitcKit\CoreBundle\Entity\Route as RouteOrm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index()
    {

    }

    /**
     * @Route("/")
     * @param ChainRouterInterface $router
     * @return Response
     */
    public function home(ChainRouterInterface $router)
    {
        $route = $router->getRouteCollection()->get('home');
        $controller = $route ? (string)$route->getDefault(RouteOrm::CONTROLLER_NAME) : false;

        if (!$controller) {
            throw $this->createNotFoundException();
        }

        return $this->forward($controller);
    }
}
