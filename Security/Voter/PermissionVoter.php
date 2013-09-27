<?php

namespace Oneup\PermissionBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Metadata\MetadataFactory;
use Doctrine\Common\Util\ClassUtils;

use Oneup\PermissionBundle\Metadata\EntityMetadata;

class PermissionVoter implements VoterInterface
{
    protected $factory;
    protected $masks;

    public function __construct(MetadataFactory $factory, array $masks)
    {
        $this->factory = $factory;
        $this->masks = $masks;
    }

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->masks);
    }

    public function supportsClass($class)
    {
        return $this->factory->getMetadataForClass($class) instanceof EntityMetadata;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $grant = true;
        $class = ClassUtils::getClass($object);

        if (!$this->supportsClass($class)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $metadata = $this->factory->getMetadataForClass($class);

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

            $metadataRoles = $metadata->getRoles();

            foreach ($token->getRoles() as $role) {
                $roleStr = $role->getRole();

                if (array_key_exists($roleStr, $metadataRoles)) {
                    $masks = $metadataRoles[$roleStr];

                    if (!in_array($attribute, $masks)) {
                        return VoterInterface::ACCESS_DENIED;
                    }
                }
            }
        }

        return VoterInterface::ACCESS_GRANTED;
    }
}
