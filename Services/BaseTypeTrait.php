<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Entity\Node;
use Symfony\Contracts\Translation\TranslatorInterface;

trait BaseTypeTrait
{
    abstract public static function getName(): string;

    public static function getLabel(TranslatorInterface $translator): string
    {
        $name = static::getName();
        $domain = preg_replace('/((?<=Bundle).+$|\\\\)/u', '', __CLASS__);
        return $translator == null ? $name : $translator->trans($name, [], $domain);
    }

    public function isEnabled(?Node $parent): bool
    {
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpUndefinedClassInspection */
        $isParentEnabled = !get_parent_class(static::class) || parent::isEnabled($parent);
        return $parent == null || (in_array($parent->getType(), [static::class]) && $isParentEnabled);
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function configureFields(string $pageName): iterable
    {
        return [];
    }
}
