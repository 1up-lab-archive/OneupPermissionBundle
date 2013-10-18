<?php

namespace Oneup\PermissionBundle\Tests\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;

use Oneup\PermissionBundle\Metadata\Mapping\Annotation;
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

    public function testEmptyDomainObjectAnnotation()
    {
        $annotation = new Annotation\ClassPermission();

        $this->assertTrue(is_array($annotation->getPermissions()));
        $this->assertEmpty($annotation->getPermissions());
    }

    public function testArrayArgumentClassPermissionAnnotation()
    {
        $annotation = new Annotation\ClassPermission(array(
            'value' => array(
                'ROLE_USER'  => array('VIEW'),
                'ROLE_ADMIN' => array('IDDQD')
            )
        ));

        $this->assertTrue(is_array($annotation->getPermissions()));
        $this->assertNotEmpty($annotation->getPermissions());

        foreach ($annotation->getPermissions() as $key => $permission) {
            $this->assertTrue(is_array($permission));
        }
    }

    public function testNonArrayArgumentClassPermissionAnnotation()
    {
        $annotation = new Annotation\ClassPermission(array(
            'value' => array(
                'ROLE_USER'  => 'VIEW',
                'ROLE_ADMIN' => 'IDDQD'
            )
        ));

        $this->assertTrue(is_array($annotation->getPermissions()));
        $this->assertNotEmpty($annotation->getPermissions());

        foreach ($annotation->getPermissions() as $key => $permission) {
            $this->assertTrue(is_array($permission));
            $this->assertCount(1, $permission);
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
