<?php

namespace HitcKit\CoreBundle\Entity;

use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RouteOrm extends Route
{
    /**
     * @ORM\Column(nullable=true)
     */
    private $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }
}
