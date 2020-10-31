<?php

namespace HitcKit\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
    /**
     * @var ?int
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
     * @var ?string
     * @ORM\Column
     */
    protected $type;

    /**
     * @var ?string
     * @ORM\Column(nullable=true)
     */
    protected $title;

    /**
     * @var ?string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $keywords;

    /**
     * @var ?string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var ?string
     * @ORM\Column(nullable=true)
     */
    protected $heading;

    /**
     * @var ?string
     * @ORM\Column(nullable=true)
     */
    protected $content;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $showInMenu = true;

    public function __construct()
    {
        $this->children = new ArrayCollection();
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $title
     * @return Node
     */
    public function setTitle(?string $title): Node
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $keywords
     * @return Node
     */
    public function setKeywords(?string $keywords): Node
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    /**
     * @param string|null $description
     * @return Node
     */
    public function setDescription(?string $description): Node
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $heading
     * @return Node
     */
    public function setHeading(?string $heading): Node
    {
        $this->heading = $heading;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeading(): ?string
    {
        return $this->heading;
    }

    /**
     * @param string|null $content
     * @return Node
     */
    public function setContent(?string $content): Node
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param bool $showInMenu
     * @return Node
     */
    public function setShowInMenu(bool $showInMenu): Node
    {
        $this->showInMenu = $showInMenu;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowInMenu(): bool
    {
        return $this->showInMenu;
    }
}
