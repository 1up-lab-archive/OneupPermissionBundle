<?php

namespace Oneup\PermissionBundle\Metadata;

use Metadata\MetadataFactory;
use Metadata\Driver\DriverChain;

class Reader
{
    public function __construct()
    {
        $driver = new DriverChain(array(

        ));
    }
}
