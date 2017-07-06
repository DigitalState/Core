<?php

namespace Ds\Component\Model\EventListener;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Model\Type\Translatable;
use Ds\Component\Model\Annotation\Translate;
use ReflectionObject;

/**
 * Class TranslatableListener
 */
class TranslatableListener
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
     * Persist the entity translations
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Translatable) {
            return;
        }

        $this->persist($entity);
    }

    /**
     * Update the entity translations
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Translatable) {
            return;
        }

        $this->persist($entity);
    }

    /**
     * Hydrate the entity translations
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
     * Persist the entity translations
     *
     * @param \Ds\Component\Model\Type\Translatable $entity
     */
    protected function persist(Translatable $entity)
    {
        $properties = $this->getTranslateProperties($entity);

        foreach ($properties as $property) {
            $get = 'get'.$property->getName();
            $set = 'set'.$property->getName();
            $values = $entity->$get();

            foreach ($values as $locale => $value) {
                $entity->translate($locale)->$set($value);
            }
        }

        $entity->mergeNewTranslations();
    }

    /**
     * Hydrate the entity translations
     *
     * @param \Ds\Component\Model\Type\Translatable $entity
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
     * @param \Ds\Component\Model\Type\Translatable $entity
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
