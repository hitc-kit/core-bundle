<?php


namespace HitcKit\CoreBundle\Services;


use HitcKit\CoreBundle\Entity\Node;
use HitcKit\CoreBundle\Entity\Route as RouteOrm;
use Symfony\Component\Routing\Route;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CoreData
{
    protected $router;
    protected $request;
    private $route;

    public function __construct(ChainRouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return Route|RouteOrm|null
     */
    public function getRoute(): ?Route
    {
        if (!isset($this->route)) {
            $name = $this->request->attributes->get('_route');
            $this->route = $this->router->getRouteCollection()->get($name);
        }

        return $this->route;
    }

    public function getNode(): ?Node
    {
        $route = $this->getRoute();
        return $route instanceof RouteOrm ? $route->getNodes()->first() : null;
    }
}
