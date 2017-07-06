<?php

namespace Ds\Component\Model\EventListener;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Ds\Component\Model\Annotation\Translate;
use Ds\Component\Model\Type\Translatable;
use Doctrine\Common\Annotations\Reader;
use ReflectionObject;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * Class LocalizableListener
 */
class LocalizableListener
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
    public function onKernelView(GetResponseForControllerResultEvent $event)
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
     * @param \Ds\Component\Model\Type\Translatable $entity
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
