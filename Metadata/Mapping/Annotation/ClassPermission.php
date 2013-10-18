<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
final class ClassPermission
{
    private $permissions;

    public function __construct($input = array())
    {
        $this->permissions = array();

        if (array_key_exists('value', $input)) {
            $permissions = $input['value'];

            // normalize array
            foreach ($permissions as $key => $permission) {
                $permissions[$key] = (array) $permission;
            }

            $this->permissions = $permissions;
        }
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}
