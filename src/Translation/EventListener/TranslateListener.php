<?php

namespace Ds\Component\Translation\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
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

        if ('post' !== $request->attributes->get('_api_collection_operation_name') && 'put' !== $request->attributes->get('_api_item_operation_name')) {
            return;
        }

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $this->load($item);
            }
        } else {
            $this->load($data);
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

        $this->load($entity);
    }

    /**
     * Load entity translations
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
