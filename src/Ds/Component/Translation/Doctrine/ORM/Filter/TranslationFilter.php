<?php

namespace Ds\Component\Translation\Doctrine\ORM\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;
use DomainException;

/**
 * Class TranslationFilter
 */
class TranslationFilter extends AbstractFilter
{
    /**
     * Filter property
     *
     * @param string $property
     * @param mixed $value
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param \ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $name = $queryNameGenerator->generateParameterName($property);
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $transAlias = $rootAlias.'_t';
        $transClass = call_user_func($resourceClass.'::getTranslationEntityClass');

        switch ($this->properties[$property]) {
            case 'partial':
                $value = '%'.$value.'%';
                break;

            case 'start':
                $value = $value.'%';
                break;

            case 'end':
                $value = '%'.$value;
                break;

            case 'word_start':
                break;

            case 'exact':
            case null:
                $value = $value;
                break;

            default:
                throw new DomainException('Filter strategy does not exist.');
        }

        $queryBuilder
            ->leftJoin($transClass, $transAlias, Join::WITH, $rootAlias.'.id = '.$transAlias.'.translatable')
            ->andWhere(sprintf('%s.%s LIKE :%s', $transAlias, $property, $name))
            ->setParameter($name, $value);
    }

    /**
     * Get description
     *
     * @param string $resourceClass
     * @return array
     */
    public function getDescription(string $resourceClass): array
    {
        $description = [];

        foreach ($this->properties as $property => $strategy) {
            $description[$property] = [
                'property' => $property,
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => ''
                ],
            ];
        }

        return $description;
    }
}