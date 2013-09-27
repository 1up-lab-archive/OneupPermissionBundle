<?php

namespace Oneup\PermissionBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PermissionVoter implements VoterInterface
{
    public function supportsAttribute($attribute)
    {
        return false;
    }

    public function supportsClass($class)
    {
        return false;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        return VoterInterface::ACCESS_ABSTAIN;
    }
}
