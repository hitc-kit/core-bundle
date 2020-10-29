<?php

namespace HitcKit\CoreBundle\Services;

class NodeTypeManager
{
    protected $types;

    public function __construct(iterable $types)
    {
        $this->types = $types;
    }
}
