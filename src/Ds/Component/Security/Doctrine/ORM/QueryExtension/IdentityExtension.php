<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;

/**
 * Class IdentityExtension
 *
 * @package Ds\Component\Security
 */
class IdentityExtension extends AuthorizationExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if (!in_array('Ds\\Component\\Model\\Type\\Identitiable', class_implements($resourceClass), true)) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->andWhere(sprintf('%s.identity = :identity', $rootAlias))
            ->setParameter('identity', $user->getIdentity())
            ->andWhere(sprintf('%s.identityUuid = :identityUuid', $rootAlias))
            ->setParameter('identityUuid', $user->getIdentityUuid());
    }
}
