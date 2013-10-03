<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
final class ClassPermission
{
    private $roles;

    public function __construct($input)
    {
        $this->roles = array();

        if (array_key_exists('value', $input)) {
            $roles = $input['value'];

            // normalize array
            foreach ($roles as $key => $role) {
                $roles[$key] = (array) $role;
            }

            $this->roles = $roles;
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }
}
