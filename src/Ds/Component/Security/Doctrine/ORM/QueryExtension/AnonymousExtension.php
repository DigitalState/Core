<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use Doctrine\ORM\QueryBuilder;
use Ds\Component\Identity\Identity;

/**
 * Class AnonymousExtension
 */
class AnonymousExtension extends IdentityExtension
{
    /**
     * {@inheritdoc}
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (Identity::ANONYMOUS !== $user->getIdentity()) {
            return;
        }

        parent::apply($queryBuilder, $resourceClass);
    }
}
