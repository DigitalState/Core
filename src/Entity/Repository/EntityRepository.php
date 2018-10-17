<?php

namespace Ds\Component\Entity\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;

/**
 * Class EntityRepository
 *
 * @package Ds\Component\Entity
 */
class EntityRepository extends BaseEntityRepository
{
    /**
     * Get count
     *
     * @param array $criteria
     * @return integer
     */
    public function getCount(array $criteria)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->count($criteria);
    }
}
