<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;
use Ds\Component\Security\Security\User\User;

/**
 * Class HandlerExtension
 */
class HandlerExtension extends AuthorizationExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.handlerUuid = :handlerUuid', $rootAlias));

        if ($user instanceof User) {
            $queryBuilder->setParameter('handlerUuid', $user->getUuid());
        } else {
            $queryBuilder->setParameter('handlerUuid', -1);
        }
    }
}
