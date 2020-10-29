<?php

namespace HitcKit\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orm_tree")
 */
class Node
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="children")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\OneToOne(targetEntity="Route")
     * @ORM\JoinColumn(name="route", referencedColumnName="name")
     */
    protected $route;

    /**
     * @var string
     * @ORM\Column
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $keywords;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Node
     */
    public function setId(int $id): Node
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Node
     */
    public function setTitle(string $title): Node
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     * @return Node
     */
    public function setKeywords(string $keywords): Node
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Node
     */
    public function setDescription(string $description): Node
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Node
     */
    public function setType(string $type): Node
    {
        $this->type = $type;

        return $this;
    }
}
