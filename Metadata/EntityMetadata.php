<?php

namespace Oneup\PermissionBundle\Metadata;

use Metadata\MergeableInterface;
use Metadata\MergeableClassMetadata;

class EntityMetadata extends MergeableClassMetadata
{
    protected $roles;

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function merge(MergeableInterface $object)
    {
        if (!$object instanceof EntityMetadata) {
            throw new \InvalidArgumentException('Object must be an instance of Oneup\PermissionBundle\Metadata\EntityMetadata.');
        }

        parent::merge($object);

        $this->permissionMap = array_merge($this->permissionMap, $object->getPermissionMap());
    }
}
