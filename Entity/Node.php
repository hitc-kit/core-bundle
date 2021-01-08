<?php

namespace HitcKit\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="orm_tree",
 *     indexes={@ORM\Index(columns={"type"})}
 * )
 */
class Node
{
    private const TYPE_REFERENCE = 'hitckit_core.reference';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ?self
     * @ORM\ManyToOne(targetEntity=Node::class, inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Node::class, mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Route", inversedBy="nodes", cascade={"persist", "refresh"})
     * @ORM\JoinColumn(name="route", referencedColumnName="name", nullable=false)
     */
    private $route;

    /**
     * @ORM\Column
     */
    private $type;

    /**
     * @ORM\Column(nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(nullable=true)
     */
    private $heading;

    /**
     * @ORM\Column(nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showInMenu = true;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority = 0;

    /**
     * @var ?self
     * @ORM\ManyToOne(targetEntity=Node::class, inversedBy="relations")
     */
    private $relation;

    /**
     * @ORM\OneToMany(targetEntity=Node::class, mappedBy="relation")
     */
    private $relations;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setType(string $type): self
    {
        if ($this->relation) {
            $this->relation->setType($type);
        } else {
            $this->type = $type;
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->relation ? $this->relation->getType() : $this->type;
    }

    public function setTitle(?string $title): self
    {
        if ($this->relation) {
            $this->relation->setTitle($title);
        } else {
            $this->title = $title;
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->relation ? $this->relation->getTitle() : $this->title;
    }

    public function setKeywords(?string $keywords): self
    {
        if ($this->relation) {
            $this->relation->setKeywords($keywords);
        } else {
            $this->keywords = $keywords;
        }

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->relation ? $this->relation->getKeywords() : $this->keywords;
    }

    public function setDescription(?string $description): self
    {
        if ($this->relation) {
            $this->relation->setDescription($description);
        } else {
            $this->description = $description;
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->relation ? $this->relation->getDescription() : $this->description;
    }

    public function setHeading(?string $heading): self
    {
        if ($this->relation) {
            $this->relation->setHeading($heading);
        } else {
            $this->heading = $heading;
        }

        return $this;
    }

    public function getHeading(): ?string
    {
        return $this->relation ? $this->relation->getHeading() : $this->heading;
    }

    public function setContent(?string $content): self
    {
        if ($this->relation) {
            $this->relation->setContent($content);
        } else {
            $this->content = $content;
        }

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->relation ? $this->relation->getContent() : $this->content;
    }

    public function setShowInMenu(bool $showInMenu): self
    {
        $this->showInMenu = $showInMenu;
        return $this;
    }

    public function isShowInMenu(): bool
    {
        return $this->showInMenu;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function setParent(?self $parent): self
    {
        if ($parent) {
            $parent->getChildren()->add($this);
        } else if ($this->parent) {
            $this->parent->getChildren()->removeElement($this);
        }

        $this->parent = $parent;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setRoute(Route $route): self
    {
        $this->route = $route;
        $route->getNodes()->add($this);
        return $this;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRelation(?self $relation): self
    {
        if ($relation) {
            $this->type = self::TYPE_REFERENCE;
            $relation->getRelations()->add($this);
        } else if ($this->relation) {
            $this->type = $this->type === self::TYPE_REFERENCE ? null : $this->type;
            $this->relation->getRelations()->removeElement($this);
        }

        $this->relation = $relation;
        return $this;
    }

    public function getRelation(): ?self
    {
        return $this->relation;
    }

    public function getRelations(): Collection
    {
        return $this->relations;
    }
}
