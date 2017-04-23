<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;

/**
 * Class EnabledExtension
 */
class EnabledExtension extends AuthorizationExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if (!in_array('Ds\\Component\\Model\\Type\\Enableable', class_implements($resourceClass), true)) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();

        if (in_array($user->getIdentity(), ['Admin', 'Staff'], true)) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->andWhere(sprintf('%s.enabled = :enabled', $rootAlias))
            ->setParameter('enabled', true);
    }
}
