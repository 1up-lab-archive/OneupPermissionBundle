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
        // see if we can find the base annotation needed to handle this file
        $base = $this->reader->getClassAnnotation($class, 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\DomainObject');

        if (!$base) {
            return null;
        }

        // found the base annotation, means we have something to return
        $metadata = new EntityMetadata($name = $class->getName());

        // find ClassPermission annotation
        $classPermission = $base->getClassPermission();

        if (!$classPermission) {
            $classPermission = $this->reader->getClassAnnotation($class, 'Oneup\PermissionBundle\MetaData\Mapping\Annotation\ClassPermission');
        }

        if ($classPermission) {
            $metadata->setClassRoles($classPermission->getRoles());
        }

        // check if there are property annotations present
        foreach ($class->getProperties() as $property) {
            $holder = $this->reader->getPropertyAnnotation($property, 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\Holder');

            if (!$holder) {
                continue;
            }
        }

        var_dump($metadata);

        return $metadata;
    }
}
