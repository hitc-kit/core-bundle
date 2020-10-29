<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Entity\Node;

class CoreType implements NodeTypeInterface
{
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getNameController(): string
    {
        // TODO: Implement getNameController() method.
    }

    public function configureFields(string $pageName): iterable
    {
        // TODO: Implement configureFields() method.
    }

    public function isEnabled(Node $parent): bool
    {
        // TODO: Implement isEnabled() method.
    }
}
