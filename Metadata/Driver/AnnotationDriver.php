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
        $annotations = $this->reader->getClassAnnotations($class);

        if (count($annotations) == 0) {
            return null;
        }

        $foundBaseClass = false;
        $metadata = new EntityMetadata($name = $class->getName());

        foreach ($annotations as $annotation) {
            if ($annotation instanceof DomainObject) {
                $foundBaseClass = true;

                if (!is_array($annotation->roles)) {
                    throw new \InvalidArgumentException('Provide an array of roles for the Permission annotation.');
                }

                foreach ($annotation->roles as $key => $role) {
                    if (!is_array($role)) {
                        $annotation->roles[$key] = (array) $role;
                    }
                }

                $metadata->setClassRoles($annotation->roles);

                // check if there are property annotations present
                foreach ($class->getProperties() as $property) {
                    $holderAnnotation = $this->reader->getPropertyAnnotation($property, 'Oneup\PermissionBundle\Metadata\Mapping\Annotation\Holder');

                    if ($holderAnnotation) {
                        // handle
                    }
                }
            }
        }

        if ($foundBaseClass) {
            return $metadata;
        }

        return null;
    }
}
