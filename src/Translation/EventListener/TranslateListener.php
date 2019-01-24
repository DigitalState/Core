<?php

namespace Ds\Component\Translation\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Ds\Component\Translation\Model\Type\Translatable;
use Ds\Component\Translation\Model\Type\Translation;
use Ds\Component\Translation\Service\TranslationService;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class TranslateListener
 *
 * @package Ds\Component\Translation
 */
final class TranslateListener
{
    /**
     * @var \Ds\Component\Translation\Service\TranslationService
     */
    private $translationService;

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
     * Transfer translations from properties to source before saving them to storage
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

        $model = $request->attributes->get('data');

        if ('post' === $request->attributes->get('_api_collection_operation_name')) {
            $this->translationService->transfer($model);
        } else if ('put' === $request->attributes->get('_api_item_operation_name')) {
            $this->translationService->transfer($model);
            $this->translationService->translate($model);
        }
    }

    /**
     * Generate a custom id before persisting the entity, if none provided
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Translatable) {
            return;
        }

        $this->translationService->transfer($entity);
    }

    /**
     * Encrypt encryptable entity properties before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Translatable) {
            return;
        }

        $this->translationService->transfer($entity);
    }

    /**
     * Transfer translations from source to properties after retrieving them from storage
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Translatable) {
            return;
        }

        $this->translationService->translate($entity);
    }
}
