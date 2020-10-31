<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Entity\Node;
use Symfony\Contracts\Translation\TranslatorInterface;
use Traversable;

class NodeTypeManager
{
    protected $types;
    protected $typesList;
    protected $translator;
    protected $nodeParent;

    public function __construct(Traversable $types, TranslatorInterface $translator)
    {
        // $watch = [iterator_to_array($types)];
        $this->types = $types;
        $this->translator = $translator;
    }

    public function getTypesList(): array {
        if (!isset($this->typesList)) {
            $this->typesList = [];

            /** @var NodeTypeInterface $type */
            foreach ($this->types as $type) {
                if ($type->isEnabled($this->nodeParent)) {
                    $this->typesList[$type::getName()] = $type::getLabel($this->translator);
                }
            }
        }

        return $this->typesList;
    }

    public function setNodeParent(?Node $nodeParent): NodeTypeManager
    {
        $this->nodeParent = $nodeParent;
        return $this;
    }
}
