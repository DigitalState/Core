<?php

namespace Ds\Component\Translation\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Translation\Model\Type\Translatable;
use Ds\Component\Translation\Service\TranslationService;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

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
     * Deny access if the user does not have proper permissions
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function kernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $entity = $request->attributes->get('_api_resource_class');

        if (null === $entity) {
            return;
        }

        if (!in_array(Translatable::class, class_implements($entity), true)) {
            return;
        }

        $entity = $request->attributes->get('data');
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
