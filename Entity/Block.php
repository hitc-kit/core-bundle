<?php

namespace HitcKit\CoreBundle\Entity;

use HitcKit\CoreBundle\Repository\BlockRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @ORM\Entity(repositoryClass=BlockRepository::class)
 * @ORM\Table(name="orm_blocks")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name = "type", type = "string")
 */
class Block
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Имя области, используемое в TWIG шаблонах.
     * @ORM\Column(type="string", length=255)
     */
    private $area;

    /**
     * @ORM\ManyToMany(targetEntity=Node::class, cascade={"persist", "refresh"})
     * @ORM\JoinTable(name="orm_blocks_to_owners")
     */
    private $owners;

    /**
     * @ORM\ManyToMany(targetEntity=Node::class, cascade={"persist", "refresh"})
     * @ORM\JoinTable(name="orm_blocks_to_except")
     */
    private $except;

    /**
     * @ORM\ManyToOne(targetEntity=Block::class, inversedBy="subblocks", cascade={"persist", "refresh"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Block::class, mappedBy="parent")
     * @ORM\OrderBy({"priority"="DESC"})
     */
    private $subblocks;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority = 0;

    /**
     * @var string Имя, используемое при выводе в меню, оглавлении и т.п.
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true);
     */
    private $controller;

    public function __construct()
    {
        $this->owners = new ArrayCollection();
        $this->except = new ArrayCollection();
        $this->subblocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(Node $owner): self
    {
        $this->owners->add($owner);

        return $this;
    }

    public function removeOwner(Node $owner): self
    {
        $this->owners->removeElement($owner);

        return $this;
    }

    public function getExcept(): Collection
    {
        return $this->except;
    }

    public function setParent(?self $parent): self
    {
        if ($parent) {
            $parent->getSubblocks()->add($this);
        } else if ($this->parent) {
            $this->parent->getSubblocks()->removeElement($this);
        }

        $this->parent = $parent;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function getSubblocks(): Collection
    {
        return $this->subblocks;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setController(?string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function getType(): ?string
    {
        return strtolower(substr(strrchr(get_class($this), '\\'), 1));
    }
}
