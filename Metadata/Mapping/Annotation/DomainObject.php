<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation\RolePermission;
use Oneup\PermissionBundle\Metadata\Mapping\Annotation\UserPermission;


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
    private $rolePermissions;
    private $userPermissions;

    public function __construct($input)
    {
        $this->rolePermissions = array();
        $this->userPermissions = array();

        if (array_key_exists('value', $input)) {
            $subAnnotations = $input['value'];

            if (!is_array($subAnnotations)) {
                $subAnnotations = array($subAnnotations);
            }

            foreach ($subAnnotations as $annotation) {

                if ($annotation instanceof RolePermission) {
                    $this->rolePermissions[] = $annotation;
                    continue;
                }

                if ($annotation instanceof UserPermission) {
                    $this->userPermissions[] = $annotation;
                    continue;
                }

                throw new \InvalidArgumentException('Only RolePermission annotation are allowed to embed in DomainObject.');
            }
        }
    }

    public function getRolePermissions()
    {
        return $this->rolePermissions;
    }

    public function getUserPermissions()
    {
        return $this->userPermissions;
    }
}
