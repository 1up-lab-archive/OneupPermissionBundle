<?php

namespace Oneup\PermissionBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Metadata\Driver\DriverInterface;

use Oneup\PermissionBundle\Metadata\EntityMetadata;
use Oneup\PermissionBundle\Metadata\Mapping\Annotation\DomainObject;

class AnnotationDriver implements DriverInterface
{
    protected $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $strDomainObject   = 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\DomainObject';
        $strRolePermission = 'Oneup\PermissionBundle\MetaData\Mapping\Annotation\RolePermission';
        $strUserPermission = 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\UserPermission';

        // see if we can find the base annotation needed to handle this file
        $base = $this->reader->getClassAnnotation($class, $strDomainObject);

        if (!$base) {
            return null;
        }

        // found the base annotation, means we have something to return
        $metadata = new EntityMetadata($name = $class->getName());

        // find ClassPermission annotations
        $rolePermissions = $base->getRolePermissions();

        foreach ($rolePermissions as $rolePermission) {
            $metadata->addRolePermission($rolePermission->getPermissions());
        }

        // find posible UserPermission annotations
        $userPermissions = $base->getUserPermissions();

        foreach ($userPermissions as $userPermission) {
            foreach ($userPermission->getPermissions() as $property => $permission) {
                $metadata->addUserPermission($property, $permission);
            }
        }

        // check if there are property annotations present
        foreach ($class->getProperties() as $property) {
            $userPermission = $this->reader->getPropertyAnnotation($property, $strUserPermission);

            if (!$userPermission) {
                continue;
            }

            $metadata->addUserPermission($property, $userPermission->getPermissions());
        }

        var_dump($metadata);

        return $metadata;
    }
}
