<?php

namespace Oneup\PermissionBundle\Metadata;

use Metadata\MergeableInterface;
use Metadata\MergeableClassMetadata;

class EntityMetadata extends MergeableClassMetadata
{
    protected $classRoles;
    protected $holders;

    public function getClassRoles()
    {
        return $this->classRoles;
    }

    public function setClassRoles(array $roles)
    {
        $this->classRoles = $roles;
    }

    public function getHolders()
    {
        return $this->holders;
    }

    public function addHolder(\ReflectionProperty $property, array $masks)
    {
        $name = $property->getName();

        if (!array_key_exists($name, $this->holders)) {
            $this->holders[$name] = array();
        }

        $this->holders[$name] = $masks;
    }

    public function merge(MergeableInterface $object)
    {
        if (!$object instanceof EntityMetadata) {
            throw new \InvalidArgumentException('Object must be an instance of Oneup\PermissionBundle\Metadata\EntityMetadata.');
        }

        parent::merge($object);

        $this->permissionMap = array_merge($this->permissionMap, $object->getPermissionMap());
        $this->holders = array_merge($this->holders, $object->getHolders());
    }
}
