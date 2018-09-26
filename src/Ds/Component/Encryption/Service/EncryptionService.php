<?php

namespace Ds\Component\Encryption\Service;

use Doctrine\Common\Annotations\Reader;
use Ds\Component\Encryption\Model\Annotation\Encrypt;
use Ds\Component\Encryption\Model\Type\Encryptable;
use ReflectionObject;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class EncryptionService
 *
 * @package Ds\Component\Encryption
 */
final class EncryptionService
{
    /**
     * @var \Ds\Component\Encryption\Service\CipherService
     */
    private $cipherService;

    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    private $annotationReader;

    /**
     * @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * Constructor
     *
     * @param \Ds\Component\Encryption\Service\CipherService $cipherService
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     */
    public function __construct(CipherService $cipherService, Reader $annotationReader)
    {
        $this->cipherService = $cipherService;
        $this->annotationReader = $annotationReader;
        $this->expressionLanguage = new ExpressionLanguage;
    }

    /**
     * Encrypt model using secret key
     *
     * @param \Ds\Component\Encryption\Model\Type\Encryptable $model
     * @return \Ds\Component\Encryption\Service\EncryptionService
     */
    public function encrypt(Encryptable $model) : EncryptionService
    {
        $properties = $this->getProperties($model);

        foreach ($properties as $property) {
            $value = $model->{'get'.$property}();
            $value = $this->cipherService->encrypt(serialize($value));
            $model->{'set'.$property}($value);
        }

        return $this;
    }

    /**
     * Decrypt model using secret key
     *
     * @param \Ds\Component\Encryption\Model\Type\Encryptable $model
     * @return \Ds\Component\Encryption\Service\EncryptionService
     */
    public function decrypt(Encryptable $model) : EncryptionService
    {
        $properties = $this->getProperties($model);

        foreach ($properties as $property) {
            $value = $model->{'get'.$property}();
            $value = unserialize($this->cipherService->decrypt($value));
            $model->{'set'.$property}($value);
        }

        return $this;
    }

    /**
     * Get properties with Encrypt annotation
     *
     * @param \Ds\Component\Encryption\Model\Type\Encryptable $model
     * @return array
     */
    public function getProperties(Encryptable $model) : array
    {
        $properties = [];
        $reflection = new ReflectionObject($model);

        foreach ($reflection->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, Encrypt::class);

            if (!$annotation) {
                continue;
            }

            if (null !== $annotation->applicable && !$this->expressionLanguage->evaluate($annotation->applicable, ['object' => $model])) {
                continue;
            }

            $properties[] = $property->name;
        }

        return $properties;
    }
}
