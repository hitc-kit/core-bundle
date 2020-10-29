<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Entity\Node;

interface NodeTypeInterface
{
    public function getName(): string;

    public function getNameController(): string;

    public function configureFields(string $pageName): iterable;

    public function isEnabled(Node $parent): bool;
}
