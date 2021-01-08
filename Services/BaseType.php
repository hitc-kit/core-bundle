<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Controller\DefaultController;
// use HitcKit\CoreBundle\Entity\Node;

class BaseType implements NodeTypeInterface
{
    use BaseTypeTrait;

    public static function getName(): string
    {
        return 'hitckit_core.base';
    }

    public function getNameController(): string
    {
        return DefaultController::class.'::index';
    }
}
