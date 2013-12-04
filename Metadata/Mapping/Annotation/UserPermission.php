<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation\PermissionHolder;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class UserPermission extends PermissionHolder
{
    public function __construct($value)
    {
        parent::__construct();

        if (array_key_exists('value', $value)) {
            $this->permissions = $value['value'];
        }
    }
}
