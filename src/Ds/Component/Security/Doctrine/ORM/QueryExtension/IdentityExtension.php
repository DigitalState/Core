<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Identity\Identity;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IdentityExtension
 *
 * @package Ds\Component\Security
 */
class IdentityExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->apply($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->apply($queryBuilder, $resourceClass);
    }

    /**
     * Apply condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if (!in_array(Identitiable::class, class_implements($resourceClass), true)) {
            return;
        }

        $identity = null;
        $identityUuid = null;
        $token = $this->tokenStorage->getToken();

        if ($token) {
            $user = $token->getUser();

            if (in_array($user->getIdentity(), [Identity::SYSTEM, Identity::STAFF], true)) {
                return;
            }

            $identity = $user->getIdentity();
            $identityUuid = $user->getIdentityUuid();
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        if (null === $identity) {
            $queryBuilder->andWhere(sprintf('%s.identity IS NULL', $rootAlias));
        } else {
            $queryBuilder
                ->andWhere(sprintf('%s.identity = :identity', $rootAlias))
                ->setParameter('identity', $identity);
        }

        if (null === $identityUuid) {
            $queryBuilder->andWhere(sprintf('%s.identityUuid IS NULL', $rootAlias));
        } else {
            $queryBuilder
                ->andWhere(sprintf('%s.identityUuid = :identityUuid', $rootAlias))
                ->setParameter('identityUuid', $identityUuid);
        }
    }
}
