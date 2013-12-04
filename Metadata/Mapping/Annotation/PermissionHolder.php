<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

abstract class PermissionHolder
{
    protected $permissions;

    public function __construct()
    {
        $this->permissions = array();
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}
