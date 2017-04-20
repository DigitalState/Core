<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;
use Ds\Component\Security\User\User;

/**
 * Class OwnerExtension
 */
class OwnerExtension extends AuthorizationExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder)
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
