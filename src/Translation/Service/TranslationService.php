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
class TranslationService
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * Constructor
     *
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Get properties with Translate annotation
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $entity
     * @return array
     */
    public function getProperties(Translatable $entity)
    {
        $reflection = new ReflectionObject($entity);
        $properties = $reflection->getProperties();

        foreach ($properties as $key => $property) {
            if (!$this->reader->getPropertyAnnotation($property, Translate::class)) {
                unset($properties[$key]);
            }
        }

        return $properties;
    }
}
