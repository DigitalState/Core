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
    protected function apply(QueryBuilder $queryBuilder)
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->andWhere(sprintf('%s.enabled = :enabled', $rootAlias))
            ->setParameter('enabled', true);
    }
}
