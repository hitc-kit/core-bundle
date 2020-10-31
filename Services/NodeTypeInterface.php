<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Entity\Node;
use Symfony\Contracts\Translation\TranslatorInterface;

interface NodeTypeInterface
{
    public static function getName(): string;

    public static function getLabel(TranslatorInterface $translator): string;

    public function getNameController(): string;

    public function isEnabled(?Node $parent): bool;

    public function configureFields(string $pageName): iterable;
}
