<?php

namespace Oneup\PermissionBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Metadata\MetadataFactory;

use Oneup\PermissionBundle\Metadata\EntityMetadata;

class PermissionVoter implements VoterInterface
{
    protected $factory;

    public function __construct(MetadataFactory $factory)
    {
        $this->factory = $factory;
    }

    public function supportsAttribute($attribute)
    {
        return false;
    }

    public function supportsClass($class)
    {
        return $factory->getMetadataForClass(get_class($class)) instanceof EntityMetadata;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        return VoterInterface::ACCESS_ABSTAIN;
    }
}
