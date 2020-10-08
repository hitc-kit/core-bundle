<?php

namespace HitcKit\CoreBundle\Entity;

use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orm_tree", indexes={@ORM\Index(name="name_idx", columns={"name"})})
 */
class TreeNode extends Route
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(unique=true)
     */
    protected $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $position = 0;

    public function __construct(array $options = [])
    {
        $this->name = uniqid('', true);
        parent::__construct($options);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return TreeNode
     */
    public function setName(string $name): TreeNode
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
     * @return TreeNode
     */
    public function setPosition(int $position): TreeNode
    {
        $this->position = $position;

        return $this;
    }
}
