<?php

namespace Ds\Component\Translation\Service;

use Doctrine\Common\Annotations\Reader;
use Ds\Component\Translation\Model\Annotation\Translate;
use Ds\Component\Translation\Model\Type\Translatable;
use Ds\Component\Translation\Model\Type\Translation;
use ReflectionClass;

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
     * Translate translatable properties
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $model
     */
    public function translate(Translatable $model)
    {
        $properties = $this->getProperties($model);

        foreach ($properties as $property) {
            $get = 'get'.$property->getName();
            $set = 'set'.$property->getName();
            $values = [];

            foreach ($model->getTranslations() as $translation) {
                $values[$translation->getLocale()] = $translation->$get();
            }

            $model->$set($values);
        }
    }

    public function aggregate(Translation $model)
    {
        $translatable = $model->getTranslatable();
        $properties = $this->getProperties($translatable);

        foreach ($properties as $property) {
            $get = 'get'.$property->getName();
            $set = 'set'.$property->getName();
            $values = $translatable->$get();
            $values[$model->getLocale()] = $model->$get();
            $translatable->$set($values);
        }
    }

    /**
     * Transfer translatable properties to translations
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $model
     */
    public function transfer(Translatable $model)
    {
        $properties = $this->getProperties($model);

        foreach ($properties as $property) {
            $get = 'get'.$property->getName();
            $set = 'set'.$property->getName();
            $values = $model->$get();

            if (null !== $values) {
                foreach ($values as $locale => $value) {
                    $model->translate($locale, false)->$set($value);
                }
            }
        }

        $model->mergeNewTranslations();
    }

    /**
     * Get properties with Translate annotation
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $model
     * @return array
     */
    public function getProperties(Translatable $model): array
    {
        $class = get_class($model);

        if (substr($class, 0, 15) === 'Proxies\\__CG__\\') {
            $class = substr($class, 15);
        }

        $properties = [];
        $reflection = new ReflectionClass($class);

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
