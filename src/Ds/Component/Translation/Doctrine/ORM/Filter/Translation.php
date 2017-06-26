<?php

namespace Ds\Component\Translation\Doctrine\ORM\Filter;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Trait Translation
 */
trait Translation
{
    /**
     * Join translation table
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     * @return string
     */
    protected function addJoinTranslation(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $translationAlias = $rootAlias.'_t';
        $translationClass = call_user_func($resourceClass.'::getTranslationEntityClass');
        $parts = $queryBuilder->getDQLParts()['join'];

        foreach ($parts as $joins) {
            foreach ($joins as $join) {
                if ($translationAlias === $join->getAlias()) {
                    return $translationAlias;
                }
            }
        }

        $queryBuilder->leftJoin(
            $translationClass,
            $translationAlias,
            Join::WITH,
            $rootAlias.'.id = '.$translationAlias.'.translatable'
        );

        return $translationAlias;
    }
}
