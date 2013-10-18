<?php

namespace Oneup\PermissionBundle\Tests\Entity;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation as Permission;

/**
 * @Permission\DomainObject(
 *   @Permission\ClassPermission({
 *     "ROLE_USER" = {"VIEW"},
 *     "ROLE_ADMIN" = {"IDDQD"}
 *   })
 * )
 */
class Resource
{
    /**
     * @Permission\ObjectPermission({"VIEW", "EDIT", "DELETE"})
     */
    protected $owner;
}
