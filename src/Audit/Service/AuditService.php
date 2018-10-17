<?php

namespace Ds\Component\Audit\Service;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManager;
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
class AuditService extends EntityService
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param \Doctrine\Common\Annotations\Reader $reader
     * @param string $entity
     */
    public function __construct(EntityManager $manager, Reader $reader, $entity = Audit::class)
    {
        parent::__construct($manager, $entity);

        $this->reader = $reader;
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
            if (!$this->reader->getPropertyAnnotation($property, AuditAnnotation::class)) {
                continue;
            }

            $properties[] = $property->name;
        }

        return $properties;
    }
}
