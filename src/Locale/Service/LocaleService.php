<?php

namespace Ds\Component\Locale\Service;

use Doctrine\Common\Annotations\Reader;
use Ds\Component\Locale\Model\Annotation\Locale;
use Ds\Component\Locale\Model\Type\Localizable;
use ReflectionObject;

/**
 * Class LocaleService
 *
 * @package Ds\Component\Locale
 */
final class LocaleService
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
     * Localize model
     *
     * @param \Ds\Component\Locale\Model\Type\Localizable $model
     * @param string $locale
     */
    public function localize(Localizable $model, string $locale)
    {
        $properties = $this->getProperties($model);

        foreach ($properties as $property) {
            $name = ucfirst($property->getName());
            $values = $model->{'get'.$name}();

            if (array_key_exists($locale, $values)) {
                $model->{'set'.$name}([$locale => $values[$locale]]);
            } else {
                $model->{'set'.$name}([$locale => null]);
            }
        }
    }

    /**
     * Get properties with Locale annotation
     *
     * @param \Ds\Component\Locale\Model\Type\Localizable $model
     * @return array
     */
    public function getProperties(Localizable $model): array
    {
        $properties = [];
        $reflection = new ReflectionObject($model);

        foreach ($reflection->getProperties() as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, Locale::class);

            if (!$annotation) {
                continue;
            }

            $properties[] = $property;
        }

        return $properties;
    }
}
