<?php

namespace Ds\Component\Translation\Doctrine\ORM\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use DomainException;

/**
 * Class SearchFilter
 */
class SearchFilter extends TranslationFilter
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
        if (!array_key_exists($property, $this->properties)) {
            return;
        }

        $this->joinTranslation($queryBuilder, $resourceClass);
        $translationAlias = $this->getTranslationAlias($queryBuilder);
        $name = $queryNameGenerator->generateParameterName($property);

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
            ->andWhere(sprintf('%s.%s LIKE :%s', $translationAlias, $property, $name))
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
