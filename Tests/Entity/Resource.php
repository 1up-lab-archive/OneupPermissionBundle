<?php

namespace Oneup\PermissionBundle\Tests\Entity;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation as Permission;

/**
 * @Permission\DomainObject(
 *   @Permission\RolePermission({
 *     "ROLE_USER" = {"VIEW"},
 *     "ROLE_ADMIN" = {"IDDQD"}
 *   })
 * )
 */
class Resource
{
    /**
     * @Permission\UserPermission({"VIEW", "EDIT", "DELETE"})
     */
    protected $owner;

    public function getOwner()
    {
        return $this->owner;
    }
}
