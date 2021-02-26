<?php

namespace HitcKit\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\Menu\NodeInterface;
use Traversable;

/**
 * @ORM\Entity
 * @ORM\Table(name="orm_tree", indexes={@ORM\Index(columns={"alias"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\HasLifecycleCallbacks
 */
class Node implements NodeInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ?self
     * @ORM\ManyToOne(targetEntity=Node::class, inversedBy="children", cascade={"persist", "refresh"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Node::class, mappedBy="parent")
     * @ORM\OrderBy({"priority"="DESC"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Route", inversedBy="nodes", cascade={"persist", "refresh"})
     * @ORM\JoinColumn(name="route", referencedColumnName="name", nullable=false)
     */
    private $route;

    /**
     * @ORM\Column(nullable=true, unique=true)
     */
    private $alias;

    /**
     * @ORM\Column(nullable=true)
     */
    private $name;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showInMenu = false;

    /**
     * @ORM\Column(type="integer", nullable=false)
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

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $depth = 0;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return strtolower(substr(strrchr(get_class($this), '\\'), 1));
    }

    public function setName(string $name): self
    {
        if ($this->relation) {
            $this->relation->setName($name);
        } else {
            $this->name = $name;
        }

        return $this;
    }

    public function getName(): string
    {
        return (string)($this->relation ? $this->relation->getName() : $this->name);
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

    /**
     * @return Collection
     */
    public function getChildren(): Traversable
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

    public function getParentByDepth(int $depth): self
    {
        return ($this->depth <= $depth || !$this->parent) ? $this : $this->parent->getParentByDepth($depth);
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
            $relation->getRelations()->add($this);
        } else if ($this->relation) {
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

    public function getOptions(): array
    {
        return [
            'route' => $this->route->getName(),
            'display' => $this->showInMenu
        ];
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    public function setDepth(int $depth): Node
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calcDepth(): void
    {
        if ($this->parent) {
            $this->depth = $this->parent->getDepth() + 1;
        }
    }
}
