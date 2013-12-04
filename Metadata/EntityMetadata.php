<?php

namespace Oneup\PermissionBundle\Metadata;

use Metadata\MergeableInterface;
use Metadata\MergeableClassMetadata;

class EntityMetadata extends MergeableClassMetadata
{
    protected $rolePermissions;
    protected $userPermissions;

    public function __construct()
    {
        $this->rolePermissions = array();
        $this->userPermissions = array();
    }

    public function getRolePermissions()
    {
        return $this->rolePermissions;
    }

    public function addRolePermission(array $permissions)
    {
        $this->rolePermissions = array_merge($this->rolePermissions, $permissions);
    }

    public function getUserPermissions()
    {
        return $this->userPermissions;
    }

    public function addUserPermission($name, array $masks)
    {
        if ($name instanceof \ReflectionProperty) {
            $name = $name->getName();
        }

        if (!array_key_exists($name, $this->userPermissions)) {
            $this->userPermissions[$name] = array();
        }

        $this->userPermissions[$name] = $masks;
    }

    public function merge(MergeableInterface $object)
    {
        if (!$object instanceof EntityMetadata) {
            throw new \InvalidArgumentException('Object must be an instance of Oneup\PermissionBundle\Metadata\EntityMetadata.');
        }

        parent::merge($object);

        $this->rolePermissions = array_merge($this->rolePermissions, $object->getRolePermissions());
        $this->userPermissions = array_merge($this->userPermissions, $object->getUserPermissions());
    }
}
