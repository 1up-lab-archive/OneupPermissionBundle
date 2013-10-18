<?php

namespace Oneup\PermissionBundle\Tests\Metadata;

abstract class AbstractDriverTest extends \PHPUnit_Framework_TestCase
{
    abstract protected function getDriverObject();

    public function testTypeOfDriver()
    {
        $driver = $this->getDriverObject();
        $this->assertInstanceOf('Metadata\Driver\DriverInterface', $driver);
    }
}
