<?php

namespace Ds\Component\Locale\EventListener;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Ds\Component\Locale\Model\Annotation\Locale;
use Ds\Component\Locale\Model\Type\Localizable;
use Doctrine\Common\Annotations\Reader;
use ReflectionObject;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * Class LocaleListener
 *
 * @package Ds\Component\Locale
 */
class LocaleListener
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
     * Serializes the data to the requested format.
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

        if ($controllerResult instanceof Paginator) {
            foreach ($controllerResult as $entity) {
                if ($entity instanceof Localizable) {
                    $this->localize($entity, $locale);
                }
            }
        } elseif ($controllerResult instanceof Localizable) {
            $this->localize($controllerResult, $locale);
        }

        $event->setControllerResult($controllerResult);
    }

    /**
     * Localize entity
     *
     * @param \Ds\Component\Locale\Model\Type\Localizable $entity
     * @param string $locale
     */
    protected function localize(Localizable $entity, $locale)
    {
        $properties = $this->getLocaleProperties($entity);

        foreach ($properties as $property) {
            $name = ucfirst($property->getName());
            $values = $entity->{'get'.$name}();

            if (array_key_exists($locale, $values)) {
                $entity->{'set'.$name}([$locale => $values[$locale]]);
            } else {
                $entity->{'set'.$name}([$locale => null]);
            }
        }
    }

    /**
     * Get properties with Locale annotation
     *
     * @param \Ds\Component\Locale\Model\Type\Localizable $entity
     * @return array
     */
    protected function getLocaleProperties(Localizable $entity)
    {
        $reflection = new ReflectionObject($entity);
        $properties = $reflection->getProperties();

        foreach ($properties as $key => $property) {
            if (!$this->reader->getPropertyAnnotation($property, Locale::class)) {
                unset($properties[$key]);
            }
        }

        return $properties;
    }
}
