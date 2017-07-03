<?php

namespace Ds\Component\Security\Serializer\Normalizer;

use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use DomainException;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Voter\Permission\PropertyVoter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PermissionNormalizer
 */
class PermissionNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
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
        $object = $this->decorated->denormalize($data, $class, $format, $context);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return $data;
        }

        $operation = null;

        if (array_key_exists('item_operation_name', $context)) {
            $operation = $context['item_operation_name'];
        } elseif (array_key_exists('collection_operation_name', $context)) {
            $operation = 'c'.$context['collection_operation_name'];
        }

        switch ($operation) {
            case 'cget':
                $attributes = [Permission::BROWSE];
                break;

            case 'get':
                $attributes = [Permission::READ];
                break;

            case 'put':
                $attributes = [Permission::EDIT];
                break;

            default:
                throw new DomainException('Operation does not exist.');
        }

        foreach (array_keys($data) as $property) {
            $subject = Permission::PROPERTY.':'.$context['resource_class'].'.'.$property;
            $vote = $this->propertyVoter->vote($token, $subject, $attributes);

            if (PropertyVoter::ACCESS_GRANTED !== $vote) {
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
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}
