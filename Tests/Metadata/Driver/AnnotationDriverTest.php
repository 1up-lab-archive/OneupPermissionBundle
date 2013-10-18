<?php

namespace Oneup\PermissionBundle\Tests\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use Oneup\PermissionBundle\Metadata\Driver\AnnotationDriver;
use Oneup\PermissionBundle\Tests\Metadata\AbstractDriverTest;

class AnnotationDriverTest extends AbstractDriverTest
{
    protected function getDriverObject()
    {
        return new AnnotationDriver(new AnnotationReader());
    }
}
