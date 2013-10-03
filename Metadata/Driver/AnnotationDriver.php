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
        $strDomainObject     = 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\DomainObject';
        $strClassPermission  = 'Oneup\PermissionBundle\MetaData\Mapping\Annotation\ClassPermission';
        $strObjectPermission = 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\ObjectPermission';

        // see if we can find the base annotation needed to handle this file
        $base = $this->reader->getClassAnnotation($class, $strDomainObject);

        if (!$base) {
            return null;
        }

        // found the base annotation, means we have something to return
        $metadata = new EntityMetadata($name = $class->getName());

        // find ClassPermission annotation
        $classPermission = $base->getClassPermission();

        if (!$classPermission) {
            $classPermission = $this->reader->getClassAnnotation($class, $strClassPermission);
        }

        if ($classPermission) {
            $metadata->setClassPermissions($classPermission->getPermissions());
        }

        // check if there are property annotations present
        foreach ($class->getProperties() as $property) {
            $objectPermission = $this->reader->getPropertyAnnotation($property, $strObjectPermission);

            if (!$objectPermission) {
                continue;
            }

            $metadata->addObjectPermission($property, $objectPermission->getPermissions());
        }

        var_dump($metadata);die();

        return $metadata;
    }
}
