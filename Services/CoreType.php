<?php

namespace HitcKit\CoreBundle\Services;

use HitcKit\CoreBundle\Controller\DefaultController;
// use HitcKit\CoreBundle\Entity\Node;

class CoreType implements NodeTypeInterface
{
    use BaseTypeTrait;

    public static function getName(): string
    {
        return 'hitc_kit_core.core_type';
    }

    public function getNameController(): string
    {
        return DefaultController::class.'::index';
    }
}
