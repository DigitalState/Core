<?php

namespace Ds\Component\Translation\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Translation\Model\Type\Translatable;
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

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $this->translationService->translate($item);
            }
        } else {
            $this->translationService->translate($data);
        }
    }
}
