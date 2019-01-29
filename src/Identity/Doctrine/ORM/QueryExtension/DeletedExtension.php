<?php

namespace Ds\Component\Identity\Doctrine\ORM\QueryExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Ds\Component\Security\Model\Identity;
use Ds\Component\Model\Type\Deletable;
use Ds\Component\Security\Model\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class DeletedExtension
 *
 * @package Ds\Component\Identity
 */
final class DeletedExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
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
        if (!in_array(Deletable::class, class_implements($resourceClass), true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if ($token) {
            $user = $token->getUser();

            if ($user instanceof User) {
                if (in_array($user->getIdentity()->getType(), [Identity::SYSTEM, Identity::STAFF], true)) {
                    $request = $this->requestStack->getCurrentRequest();
                    $deleted = $request->query->get('deleted', 'false');
                    $rootAlias = $queryBuilder->getRootAliases()[0];

                    switch ($deleted) {
                        case 'true':
                            $queryBuilder->andWhere($rootAlias . '.deletedAt IS NOT NULL');
                            break;

                        case 'false':
                            $queryBuilder->andWhere($rootAlias . '.deletedAt IS NULL');
                            break;

                        case 'null':
                            break;
                    }

                    return;
                }
            }
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere($rootAlias.'.deletedAt IS NULL');
    }
}
