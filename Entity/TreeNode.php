<?php

namespace HitcKit\CoreBundle\Entity;

use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

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
     * @var UuidInterface
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $position = 0;

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
     * @param UuidInterface $name
     * @return TreeNode
     */
    public function setName(UuidInterface $name): TreeNode
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
