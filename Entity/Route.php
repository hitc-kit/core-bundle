<?php

namespace HitcKit\CoreBundle\Entity;

use Symfony\Cmf\Bundle\RoutingBundle\Model\Route as RouteModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="orm_routes",
 *     indexes={@ORM\Index(columns={"staticPrefix"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"group_route", "staticPrefix"})}
 * )
 */
class Route extends RouteModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=23)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $position = 0;

    /**
     * @ORM\Column
     */
    private $groupRoute = 'main_tree';

    public function __construct(array $options = [])
    {
        $this->name = uniqid('', true);
        parent::__construct($options);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Route
    {
        if (!empty($name)) {
            $this->name = $name;
        }

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): Route
    {
        $this->position = $position;
        return $this;
    }

    public function getGroupRoute(): string
    {
        return $this->groupRoute;
    }

    public function setGroupRoute(string $groupRoute): Route
    {
        $this->groupRoute = $groupRoute;
        return $this;
    }
}
