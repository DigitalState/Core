<?php

namespace Ds\Component\Entity\EventListener\Request;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Ds\Component\Entity\Entity\Translatable;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Ds\Component\Entity\Annotation\Translate;
use Doctrine\Common\Annotations\Reader;
use ReflectionObject;

/**
 * Class LocaleListener
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

        if (!$controllerResult instanceof Paginator && !$controllerResult instanceof Translatable) {
            return;
        }

        $locale = $request->query->get('locale');

        if ($controllerResult instanceof Paginator) {
            foreach ($controllerResult as $entity) {
                $this->applyLocale($entity, $locale);
            }
        } elseif ($controllerResult instanceof Translatable) {
            $this->applyLocale($controllerResult, $locale);
        }

        $event->setControllerResult($controllerResult);
    }

    /**
     * Apply locale to entity
     *
     * @param \Ds\Component\Entity\Entity\Translatable $entity
     * @param string $locale
     */
    protected function applyLocale(Translatable $entity,  $locale)
    {
        $properties = $this->getTranslateProperties($entity);

        foreach ($properties as $property) {
            $name = ucfirst($property->getName());
            $values = $entity->{'get'.$name}();

            if (array_key_exists($locale, $values)) {
                $entity->{'set'.$name}($values[$locale]);
            } else {
                $entity->{'set'.$name}(null);
            }
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
