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

        // find ClassPermission annotation
        $rolePermission = $base->getRolePermission();

        if (!$rolePermission) {
            $rolePermission = $this->reader->getClassAnnotation($class, $strRolePermission);
        }

        if ($rolePermission) {
            $metadata->setRolePermissions($rolePermission->getPermissions());
        }

        // check if there are property annotations present
        foreach ($class->getProperties() as $property) {
            $userPermission = $this->reader->getPropertyAnnotation($property, $strUserPermission);

            if (!$userPermission) {
                continue;
            }

            $metadata->addUserPermission($property, $userPermission->getPermissions());
        }

        return $metadata;
    }
}
