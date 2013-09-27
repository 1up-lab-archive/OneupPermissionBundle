<?php

namespace Oneup\PermissionBundle\Metadata;

use Metadata\MergeableClassMetadata;

class EntityMetadata implements MergeableClassMetadata
{
    protected $permissionMap;

    public function setPermissionMap(array $map)
    {
        $this->permissionMap = $map;
    }

    public function getPermissionMap()
    {
        return $this->permissionMap;
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
