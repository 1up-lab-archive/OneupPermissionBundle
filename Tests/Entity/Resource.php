<?php

namespace Oneup\PermissionBundle\Tests\Entity;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation as Permission;

/**
 * @Permission\DomainObject(
 *   @Permission\RolePermission({
 *     "ROLE_USER" = {"VIEW"},
 *     "ROLE_ADMIN" = {"IDDQD"}
 *   })
 *   @Permission\UserPermission({
 *     "owner" = {"VIEW"},
 *     "stakeholders" = {"VIEW", "EDIT"}
 *   })
 * )
 */
class Resource
{
    /**
     * @Permission\UserPermission({"VIEW"})
     */
    protected $owner;

    /**
     * @Permission\UserPermission({"VIEW", "EDIT"})
     */
    protected $stakeholders;

    public function __construct()
    {
        $this->stakeholders = array();
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getStakeholders()
    {
        return $this->stakeholders;
    }

    public function setStakeholders(array $holders)
    {
        $this->stakeholders = $holders;
    }

    public function addStakeholder($holder)
    {
        $this->stakeholders[] = $holder;
    }
}
