<?php

namespace HitcKit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HitcKit\CoreBundle\Repository\BlockTextRepository;

/**
 * @ORM\Entity(repositoryClass=BlockTextRepository::class)
 * @ORM\Table(name="orm_blocks_text")
 */
class BlockText extends Block
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heading;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function setHeading(?string $heading): self
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
