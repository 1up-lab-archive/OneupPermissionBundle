<?php

namespace Oneup\PermissionBundle\Tests\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;

use Oneup\PermissionBundle\Metadata\Driver\AnnotationDriver;
use Oneup\PermissionBundle\Tests\Entity\Resource;
use Oneup\PermissionBundle\Tests\Metadata\AbstractDriverTest;

class AnnotationDriverTest extends AbstractDriverTest
{
    public function setUp()
    {
        $path = __DIR__ . '/../../../Metadata/Mapping/Annotation/*.php';

        foreach (glob($path) as $annotation) {
            AnnotationRegistry::registerFile($annotation);
        }
    }

    protected function getDomainObject()
    {
        return new Resource();
    }

    protected function getDriverObject()
    {
        return new AnnotationDriver(new AnnotationReader());
    }
}
