<?php

namespace HitcKit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TreeNodeInterface;
use Knp\DoctrineBehaviors\Model\Tree\TreeNodeTrait;

/**
 * @ORM\Entity
 */
class Node implements TreeNodeInterface
{
    use TreeNodeTrait;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    public function __toString() : string
    {
        return (string) $this->name;
    }
}
