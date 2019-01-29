<?php

namespace Ds\Component\Translation\Doctrine\ORM\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter as BaseOrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use DomainException;

/**
 * Class OrderFilter
 *
 * @package Ds\Component\Translation
 */
final class OrderFilter extends BaseOrderFilter
{
    use Translation;

    /**
     * @const string
     */
    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';

    /**
     * Filter property
     *
     * @param string $property
     * @param mixed $order
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param \ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     * @throws \DomainException
     */
    protected function filterProperty(string $property, $order, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (!$this->isPropertyEnabled($property)) {
            return;
        }

        $alias = $this->addJoinTranslation($queryBuilder, $resourceClass);
        $order = strtoupper($order);

        if (!in_array($order, [static::ORDER_ASC, static::ORDER_DESC], true)) {
            throw new DomainException('Filter order "'.$order.'" does not exist.');
        }

        $queryBuilder->addOrderBy(sprintf('%s.%s', $alias, $property), $order);
    }
}
