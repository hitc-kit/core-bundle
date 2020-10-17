<?php

namespace HitcKit\CoreBundle\Entity;

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

    /**
     * @var string
     * @ORM\Column
     */
    protected $type;

    /* TODO: Добавить связь с на себя самого */
    protected $parent;

    /* TODO: Добавить связь на Route через поле "name" */
    protected $route;

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
