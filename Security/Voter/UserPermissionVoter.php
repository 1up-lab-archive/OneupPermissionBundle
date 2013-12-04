<?php

namespace Oneup\PermissionBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Metadata\MetadataFactory;
use Doctrine\Common\Util\ClassUtils;

use Oneup\PermissionBundle\Metadata\EntityMetadata;
use Oneup\PermissionBundle\Security\MaskHierarchy;

class UserPermissionVoter implements VoterInterface
{
    protected $factory;
    protected $masks;

    public function __construct(MetadataFactory $factory, MaskHierarchy $maskHierarchy, PropertyAccessor $accessor)
    {
        $this->factory = $factory;
        $this->maskHierarchy = $maskHierarchy;
        $this->accessor = $accessor;
    }

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->maskHierarchy->getMasks());
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
        $metadataUsers = $metadata->getUserPermissions();

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

            foreach ($metadataUsers as $property => $permissions) {
                $holder = $this->accessor->getValue($object, $property);

                if ($holder->getUser() == $token->getUser()) {

                    if (in_array($attribute, $permissions)) {
                        return VoterInterface::ACCESS_GRANTED;
                    }

                }
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
