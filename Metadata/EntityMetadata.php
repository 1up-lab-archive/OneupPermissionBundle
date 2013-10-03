<?php

namespace Oneup\PermissionBundle\Metadata;

use Metadata\MergeableInterface;
use Metadata\MergeableClassMetadata;

class EntityMetadata extends MergeableClassMetadata
{
    protected $classPermissions;
    protected $objectPermissions;

    public function __construct()
    {
        $this->classPermissions = array();
        $this->objectPermissions = array();
    }

    public function getClassPermissions()
    {
        return $this->classPermissions;
    }

    public function setClassPermissions(array $permissions)
    {
        $this->classPermissions = $permissions;
    }

    public function getObjectPermissions()
    {
        return $this->objectPermissions();
    }

    public function addObjectPermission(\ReflectionProperty $property, array $masks)
    {
        $name = $property->getName();

        if (!array_key_exists($name, $this->objectPermissions)) {
            $this->objectPermissions[$name] = array();
        }

        $this->objectPermissions[$name] = $masks;
    }

    public function merge(MergeableInterface $object)
    {
        if (!$object instanceof EntityMetadata) {
            throw new \InvalidArgumentException('Object must be an instance of Oneup\PermissionBundle\Metadata\EntityMetadata.');
        }

        parent::merge($object);

        $this->classPermissions = array_merge($this->classPermissions, $object->getClassPermissions());
        $this->objectPermissions = array_merge($this->objectPermissions, $object->getObjectPermissions());
    }
}
