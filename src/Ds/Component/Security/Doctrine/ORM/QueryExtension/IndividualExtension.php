<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;

/**
 * Class IndividualExtension
 */
class IndividualExtension extends IdentityExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ('Individual' !== $user->getIdentity()) {
            return;
        }

        parent::apply($queryBuilder, $resourceClass);
    }
}
