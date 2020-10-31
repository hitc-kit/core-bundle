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
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", length=23)
     */
    protected $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $position = 0;

    /**
     * @var string
     * @ORM\Column
     */
    protected $groupRoute = 'main_tree';

    public function __construct(array $options = [])
    {
        $this->name = uniqid('', true);
        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Route
     */
    public function setName(string $name): Route
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Route
     */
    public function setPosition(int $position): Route
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupRoute(): string
    {
        return $this->groupRoute;
    }

    /**
     * @param string $groupRoute
     * @return Route
     */
    public function setGroupRoute(string $groupRoute): Route
    {
        $this->groupRoute = $groupRoute;

        return $this;
    }
}
