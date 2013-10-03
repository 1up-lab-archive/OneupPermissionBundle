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

        if (!is_array($base->roles)) {
            throw new \InvalidArgumentException('Provide an array of roles for the Permission annotation.');
        }

        // normalize role array
        foreach ($base->roles as $key => $role) {
            $base->roles[$key] = (array) $role;
        }

        $metadata->setClassRoles($base->roles);

        // check if there are property annotations present
        foreach ($class->getProperties() as $property) {
            $holder = $this->reader->getPropertyAnnotation($property, 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\Holder');

            if (!$holder) {
                continue;
            }
        }

        return $metadata;
    }
}
