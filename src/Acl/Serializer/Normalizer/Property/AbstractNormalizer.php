<?php

namespace Ds\Component\Acl\Serializer\Normalizer\Property;

use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use DomainException;
use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Model\Permission;
use Ds\Component\Acl\Voter\PropertyVoter;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractNormalizer
 *
 * @package Ds\Component\Acl
 */
abstract class AbstractNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var \ApiPlatform\Core\Serializer\AbstractItemNormalizer
     */
    private $decorated;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var \Ds\Component\Acl\Voter\PropertyVoter
     */
    private $propertyVoter;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    private $serializer;

    /**
     * @var \Ds\Component\Acl\Collection\EntityCollection
     */
    private $entityCollection;

    /**
     * Constructor
     *
     * @param \ApiPlatform\Core\Serializer\AbstractItemNormalizer $decorated
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Acl\Voter\PropertyVoter $propertyVoter
     * @param \Ds\Component\Acl\Collection\EntityCollection $entityCollection
     */
    public function __construct(AbstractItemNormalizer $decorated, TokenStorageInterface $tokenStorage, PropertyVoter $propertyVoter, EntityCollection $entityCollection)
    {
        $this->decorated = $decorated;
        $this->tokenStorage = $tokenStorage;
        $this->propertyVoter = $propertyVoter;
        $this->entityCollection = $entityCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $this->decorated->supportsDenormalization($data, $type, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if ($this->entityCollection->contains($class)) {
            $token = $this->tokenStorage->getToken();

            if (!$token) {
                throw new LogicException('Token is not defined.');
            }

            $attribute = Permission::EDIT;
            $subject = [
                0 => null,
                1 => null
            ];

            if (array_key_exists('object_to_populate', $context)) {
                $subject[0] = $context['object_to_populate'];
            } else {
                $object = new $context['resource_class'];

                foreach ($data as $property => $value) {
                    if (in_array($property, ['uuid', 'owner', 'ownerUuid', 'identity', 'identityUuid'], true)) {
                        // Set the required values for permission scope voters to vote on.
                        $object->{'set'.$property}($value);
                    }
                }

                $subject[0] = $object;
            }

            foreach (array_keys($data) as $property) {
                $subject[1] = $property;
                $vote = $this->propertyVoter->vote($token, $subject, [$attribute]);

                if (PropertyVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (PropertyVoter::ACCESS_DENIED === $vote) {
                    unset($data[$property]);
                }
            }
        }

        return $this->decorated->denormalize($data, $class, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);
        $class = get_class($object);

        if ($this->entityCollection->contains($class)) {
            $token = $this->tokenStorage->getToken();

            if (!$token) {
                throw new LogicException('Token is not defined.');
            }

            switch (true) {
                case array_key_exists('collection_operation_name', $context):
                    $attribute = Permission::BROWSE;
                    break;

                case array_key_exists('item_operation_name', $context):
                    $attribute = Permission::READ;
                    break;

                default:
                    throw new DomainException('Operation does not exist.');
            }

            $subject = [
                0 => $object,
                1 => null
            ];

            foreach (array_keys($data) as $property) {
                $subject[1] = $property;
                $vote = $this->propertyVoter->vote($token, $subject, [$attribute]);

                if (PropertyVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (PropertyVoter::ACCESS_DENIED === $vote) {
                    unset($data[$property]);
                }
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}
