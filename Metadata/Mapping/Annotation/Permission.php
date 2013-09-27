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
final class Permission
{
    public $roles;
}
