<?php

namespace Ds\Component\Translation\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Translation\Model\Type\Translatable;
use Ds\Component\Translation\Service\TranslationService;

/**
 * Class TranslateListener
 *
 * @package Ds\Component\Translation
 */
class TranslateListener
{
    /**
     * @var \Ds\Component\Translation\Service\TranslationService
     */
    protected $translationService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Translation\Service\TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
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
        $properties = $this->translationService->getProperties($entity);

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
}
