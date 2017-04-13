<?php

namespace Ds\Component\Entity\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Entity\Entity\Translatable;
use Ds\Component\Entity\Annotation\Translate;
use Doctrine\Common\Annotations\Reader;
use ReflectionObject;

/**
 * Class TranslationListener
 */
class TranslationListener
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
     * Pre persist
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
     * Pre update
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
     * Pre persist
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
     * Persist entity
     *
     * @param \Ds\Component\Entity\Entity\Translatable $entity
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
     * Load entity
     *
     * @param \Ds\Component\Entity\Entity\Translatable $entity
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
     * @param \Ds\Component\Entity\Entity\Translatable $entity
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
