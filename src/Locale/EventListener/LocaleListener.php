<?php

namespace Ds\Component\Locale\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Locale\Model\Type\Localizable;
use Ds\Component\Locale\Service\LocaleService;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * Class LocaleListener
 *
 * @package Ds\Component\Locale
 */
final class LocaleListener
{
    /**
     * @var \Ds\Component\Locale\Service\LocaleService
     */
    private $localeService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Locale\Service\LocaleService $localeService
     */
    public function __construct(LocaleService $localeService)
    {
        $this->localeService = $localeService;
    }

    /**
     * Filter the returned data for a given locale
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent $event
     */
    public function kernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->query->has('locale')) {
            return;
        }

        $controllerResult = $event->getControllerResult();
        $locale = $request->query->get('locale');

        if ($controllerResult instanceof Paginator || is_array($controllerResult)) {
            foreach ($controllerResult as $model) {
                if ($model instanceof Localizable) {
                    $this->localeService->localize($model, $locale);
                }
            }
        } elseif ($controllerResult instanceof Localizable) {
            $this->localeService->localize($controllerResult, $locale);
        }

        $event->setControllerResult($controllerResult);
    }
}
