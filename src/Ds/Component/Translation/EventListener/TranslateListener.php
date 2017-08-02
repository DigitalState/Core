<?php

namespace Ds\Component\Translation\EventListener;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Translation\Model\Type\Translatable;
use Ds\Component\Translation\Model\Annotation\Translate;
use ReflectionObject;

/**
 * Class TranslateListener
 *
 * @package Ds\Component\Translation
 */
class TranslateListener
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
     * Post load
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Translatable) {
            return;
        }

        $this->load($entity);
    }

    /**
     * Load entity translation
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $entity
     */
    protected function load(Translatable $entity)
    {
        $properties = $this->getTranslateProperties($entity);

        foreach ($properties as $property) {
            $get = 'get'.$property->getName();
            $set = 'set'.$property->getName();
            $values = [];

            foreach ($entity->getTranslations() as $translation) {
                $values[$translation->getLocale()] = $translation->$get();
            }

            $entity->$set($values);
        }
    }

    /**
     * Get properties with Translate annotation
     *
     * @param \Ds\Component\Translation\Model\Type\Translatable $entity
     * @return array
     */
    protected function getTranslateProperties(Translatable $entity)
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