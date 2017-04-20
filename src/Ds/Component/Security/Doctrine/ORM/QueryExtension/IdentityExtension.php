<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;
use LogicException;

/**
 * Class IdentityExtension
 */
class IdentityExtension extends AuthorizationExtension
{
    /**
     * @const string
     */
    const IDENTITY = null;

    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder)
    {
        if (null === static::IDENTITY) {
            throw new LogicException('Identity is not defined.');
        }

        $user = $this->tokenStorage->getToken()->getUser();

        if (static::IDENTITY !== $user->getIdentity()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->andWhere(sprintf('%s.identity = :identity', $rootAlias))
            ->setParameter('identity', $user->getIdentity())
            ->andWhere(sprintf('%s.identityUuid = :identityUuid', $rootAlias))
            ->setParameter('identityUuid', $user->getIdentityUuid());
    }
}
