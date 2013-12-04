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
                $holders = $this->accessor->getValue($object, $property);

                if (is_array($holders) && count($holders) == 0) {
                    continue;
                }

                if (is_null($holders)) {
                    continue;
                }

                if (!is_array($holders) && !($holders instanceof \Traversable)) {
                    $holders = array($holders);
                }

                foreach ($holders as $holder) {
                    if ($this->checkHolderAccess($holder, $token, $attribute, $permissions)) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                }
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }

    protected function checkHolderAccess(TokenInterface $holder, TokenInterface $token, $attribute, array $permissions)
    {
        if ($holder->getUser() != $token->getUser()) {
            return false;
        }

        return in_array($attribute, $permissions);
    }
}
