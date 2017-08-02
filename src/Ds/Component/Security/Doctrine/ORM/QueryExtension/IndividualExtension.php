<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;
use Ds\Component\Identity\Identity;

/**
 * Class IndividualExtension
 *
 * @package Ds\Component\Security
 */
class IndividualExtension extends IdentityExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (Identity::INDIVIDUAL !== $user->getIdentity()) {
            return;
        }

        parent::apply($queryBuilder, $resourceClass);
    }
}
