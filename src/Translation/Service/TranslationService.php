<?php

namespace Ds\Component\Translation\Service;

use Doctrine\Common\Annotations\Reader;
use Ds\Component\Translation\Model\Annotation\Translate;
use Ds\Component\Translation\Model\Type\Translatable;
use ReflectionObject;

/**
 * Class TranslationService
 *
 * @package Ds\Component\Translation
 */
final class TranslationService
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    private $annotationReader;

    /**
     * Constructor
     *
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * Get properties with Translate annotation
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $model
     * @return array
     */
    public function getProperties(Translatable $model): array
    {
        $properties = [];
        $reflection = new ReflectionObject($model);

        foreach ($reflection->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, Translate::class);

            if (!$annotation) {
                continue;
            }

            $properties[] = $property;
        }

        return $properties;
    }
}
