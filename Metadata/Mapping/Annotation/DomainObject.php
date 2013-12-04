<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation\RolePermission;

/**
 * This is the base annotation. If a class should
 * be handled by this bundle, it must be annotated
 * with this annotation.
 *
 * @Annotation
 * @Target({"CLASS"})
 */
final class DomainObject
{
    private $rolePermission;

    public function __construct($input)
    {
        if (array_key_exists('value', $input)) {
            $subAnnotation = $input['value'];

            if (!$subAnnotation instanceof RolePermission) {
                throw new \InvalidArgumentException('Only RolePermission annotation are allowed to embed in DomainObject.');
            }

            $this->rolePermission = $subAnnotation;
        }
    }

    public function getRolePermission()
    {
        return $this->rolePermission;
    }
}
