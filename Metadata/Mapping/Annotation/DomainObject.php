<?php

namespace Oneup\PermissionBundle\Metadata\Mapping\Annotation;

/**
 * This is the base annotation. If a class should
 * be handled by this bundle, it must be annotated
 * with this annotation.
 *
 * @Annotation
 * @Target({"CLASS"})
 */
final class DomainObject
{
    private $classPermission;

    public function __construct($input)
    {
        if (array_key_exists('value', $input)) {
            $subAnnotation = $input['value'];

            if (!$subAnnotation instanceof ClassPermission) {
                throw new \InvalidArgumentException('Only ClassPermission annotation are allowed to embed in DomainObject.');
            }

            $this->classPermission = $subAnnotation;
        }
    }

    public function getClassPermission()
    {
        return $this->classPermission;
    }
}
