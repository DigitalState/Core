<?php

namespace Ds\Component\Translation\Doctrine\ORM\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class TranslationFilter
 */
abstract class TranslationFilter extends AbstractFilter
{
    /**
     * Join translation table
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    protected function joinTranslation(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $joined = false;
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $translationAlias = $this->getTranslationAlias($queryBuilder);
        $translationClass = call_user_func($resourceClass.'::getTranslationEntityClass');
        $parts = $queryBuilder->getDQLParts()['join'];

        foreach ($parts as $joins) {
            foreach ($joins as $join) {
                if ($translationAlias === $join->getAlias()) {
                    $joined = true;
                    break 2;
                }
            }
        }

        if (!$joined) {
            $queryBuilder->leftJoin(
                $translationClass,
                $translationAlias,
                Join::WITH,
                $rootAlias.'.id = '.$translationAlias.'.translatable'
            );
        }
    }

    /**
     * Get translation alias
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @return string
     */
    protected function getTranslationAlias(QueryBuilder $queryBuilder) : string
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $translationAlias = $rootAlias.'_t';

        return $translationAlias;
    }
}
