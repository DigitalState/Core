<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;
use Ds\Component\Security\User\User;

/**
 * Class OwnerExtension
 *
 * @package Ds\Component\Security
 */
class OwnerExtension extends AuthorizationExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.ownerUuid = :ownerUuid', $rootAlias));

        if ($user instanceof User) {
            $queryBuilder->setParameter('ownerUuid', $user->getUuid());
        } else {
            $queryBuilder->setParameter('ownerUuid', -1);
        }
    }
}
