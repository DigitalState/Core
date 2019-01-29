<?php

namespace Ds\Component\Audit\Service;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Audit\Entity\Audit;
use Ds\Component\Audit\Model\Annotation\Audit as AuditAnnotation;
use Ds\Component\Audit\Model\Type\Auditable;
use Ds\Component\Entity\Service\EntityService;
use ReflectionObject;

/**
 * Class AuditService
 *
 * @package Ds\Component\Audit
 */
final class AuditService extends EntityService
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    private $annotationReader;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, Reader $annotationReader, $entity = Audit::class)
    {
        parent::__construct($manager, $entity);

        $this->annotationReader = $annotationReader;
    }

    /**
     * Get properties with Audit annotation
     *
     * @param \Ds\Component\Audit\Model\Type\Auditable $entity
     * @return array
     */
    public function getProperties(Auditable $entity)
    {
        $reflection = new ReflectionObject($entity);
        $properties = [];

        foreach ($reflection->getProperties() as $key => $property) {
            if (!$this->annotationReader->getPropertyAnnotation($property, AuditAnnotation::class)) {
                continue;
            }

            $properties[] = $property->name;
        }

        return $properties;
    }
}
