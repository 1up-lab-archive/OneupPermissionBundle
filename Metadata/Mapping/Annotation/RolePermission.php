<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

use Oneup\PermissionBundle\Metadata\Mapping\PermissionHolderInterface;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
final class RolePermission extends PermissionHolder
{
    public function __construct($input = array())
    {
        parent::__construct();

        if (array_key_exists('value', $input)) {
            $permissions = $input['value'];

            // normalize array
            foreach ($permissions as $key => $permission) {
                $permissions[$key] = (array) $permission;
            }

            $this->permissions = $permissions;
        }
    }
}
