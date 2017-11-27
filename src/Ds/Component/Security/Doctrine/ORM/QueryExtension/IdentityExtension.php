<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Identity\Identity;
use ReflectionClass;
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

        $entity = basename(str_replace('\\', '/', $resourceClass));
        $reflection = new ReflectionClass(Identity::class);
        $identities = $reflection->getConstants();
        $rootAlias = $queryBuilder->getRootAliases()[0];

        switch (true) {
            case null === $identity && in_array($entity, $identities):
                break;

            case null === $identity && !in_array($entity, $identities):
                $queryBuilder->andWhere(sprintf('%s.identity IS NULL', $rootAlias));

                break;

            case null !== $identity && in_array($entity, $identities):
                break;

            case null !== $identity && !in_array($entity, $identities):
                $queryBuilder
                    ->andWhere(sprintf('%s.identity = :identity', $rootAlias))
                    ->setParameter('identity', $identity);

                break;
        }

        switch (true) {
            case null === $identityUuid && in_array($entity, $identities):
                $queryBuilder->andWhere(sprintf('%s.uuid IS NULL', $rootAlias));

                break;

            case null === $identityUuid && !in_array($entity, $identities):
                $queryBuilder->andWhere(sprintf('%s.identityUuid IS NULL', $rootAlias));

                break;

            case null !== $identityUuid && in_array($entity, $identities):
                $queryBuilder
                    ->andWhere(sprintf('%s.uuid = :identityUuid', $rootAlias))
                    ->setParameter('identityUuid', $identityUuid);

                break;

            case null !== $identityUuid && !in_array($entity, $identities):
                $queryBuilder
                    ->andWhere(sprintf('%s.identityUuid = :identityUuid', $rootAlias))
                    ->setParameter('identityUuid', $identityUuid);

                break;
        }
    }
}
