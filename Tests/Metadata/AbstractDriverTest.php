<?php

namespace Oneup\PermissionBundle\Tests\Metadata;

abstract class AbstractDriverTest extends \PHPUnit_Framework_TestCase
{
    abstract protected function getDriverObject();
    abstract protected function getDomainObject();

    public function testTypeOfDriver()
    {
        $driver = $this->getDriverObject();
        $this->assertInstanceOf('Metadata\Driver\DriverInterface', $driver);
    }

    public function testDriverReturnValue()
    {
        $driver = $this->getDriverObject();
        $object = $this->getDomainObject();

        $metadata = $driver->loadMetadataForClass(new \ReflectionClass($object));

        $this->assertInstanceOf('Oneup\PermissionBundle\Metadata\EntityMetadata', $metadata);
    }
}
