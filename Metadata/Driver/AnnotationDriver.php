<?php

namespace Oneup\PermissionBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Metadata\Driver\DriverInterface;

use Oneup\PermissionBundle\Metadata\EntityMetadata;
use Oneup\PermissionBundle\Metadata\Mapping\Annotation\Permission;

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

        $metadata = new EntityMetadata($name = $class->getName());

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Permission) {
                if (!is_array($annotation->roles)) {
                    throw new \InvalidArgumentException('Provide an array of roles for the Permission annotation.');
                }

                foreach ($annotation->roles as $key => $role) {
                    if (!is_array($role)) {
                        $annotation->roles[$key] = (array) $role;
                    }
                }

                $metadata->setRoles($annotation->roles);
            }
        }

        return $metadata;
    }
}
