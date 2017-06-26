<?php

namespace Ds\Component\Translation\Doctrine\ORM\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter as BaseSearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class SearchFilter
 */
class SearchFilter extends BaseSearchFilter
{
    use Translation;

    /**
     * Filter property
     *
     * @param string $property
     * @param mixed $value
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param \ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     * @throws \DomainException
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (!$this->isPropertyEnabled($property)) {
            return;
        }

        $strategy = $this->properties[$property] ?? self::STRATEGY_EXACT;
        $alias = $this->addJoinTranslation($queryBuilder, $resourceClass);
        $caseSensitive = true;

        if (strpos($strategy, 'i') === 0) {
            $strategy = substr($strategy, 1);
            $caseSensitive = false;
        }

        $this->addWhereByStrategy($strategy, $queryBuilder, $queryNameGenerator, $alias, $property, $value, $caseSensitive);
    }
}
