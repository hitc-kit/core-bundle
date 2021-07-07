<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Entity\Node;
use HitcKit\CoreBundle\Entity\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;

class CoreData
{
    protected $doctrine;
    protected $request;

    public function __construct(ManagerRegistry $doctrine, RequestStack $requestStack)
    {
        $this->doctrine = $doctrine;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getRoute(): ?Route
    {
        $name = $this->request->attributes->get('_route');

        return $this->doctrine->getRepository(Route::class)->find($name);
    }

    public function getNode(): ?Node
    {
        $route = $this->getRoute();
        return $route ? $route->getNodes()->first() : null;
    }
}
