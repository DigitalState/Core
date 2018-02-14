<?php

namespace Ds\Component\Security\Serializer\Normalizer\Acl;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use DomainException;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Model\Subject;
use Ds\Component\Security\Model\Type\Secured;
use Ds\Component\Security\Voter\Permission\PropertyVoter;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class PropertyNormalizer
 *
 * @package Ds\Component\Security
 */
class PropertyNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var \ApiPlatform\Core\Serializer\AbstractItemNormalizer
     */
    protected $decorated;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Security\Voter\Permission\PropertyVoter
     */
    protected $propertyVoter;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    protected $serializer;

    /**
     * Constructor
     *
     * @param \ApiPlatform\Core\Serializer\AbstractItemNormalizer $decorated
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Security\Voter\Permission\PropertyVoter $propertyVoter
     */
    public function __construct(AbstractItemNormalizer $decorated, TokenStorageInterface $tokenStorage, PropertyVoter $propertyVoter)
    {
        $this->decorated = $decorated;
        $this->tokenStorage = $tokenStorage;
        $this->propertyVoter = $propertyVoter;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
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
                $object->{'set'.$property}($value);
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

        return $this->decorated->denormalize($data, $class, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);
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

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if (!in_array(Secured::class, class_implements($type), true)) {
            return false;
        }

        return $this->decorated->supportsDenormalization($data, $type, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        if (!$data instanceof Secured) {
            return false;
        }

        return $this->decorated->supportsNormalization($data, $format);
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
