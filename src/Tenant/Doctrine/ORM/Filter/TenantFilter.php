<?php

namespace Ds\Component\Tenant\Doctrine\ORM\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Ds\Component\Tenant\Model\Type\Tenantable;

/**
 * Class TenantFilter
 *
 * @package Ds\Component\Tenant
 */
final class TenantFilter extends SQLFilter
{
    /**
     * Add a tenant sql condition if the entity is tenantable
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $targetEntity
     * @param string $targetTableAlias
     * @return string
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface(Tenantable::class)) {
            return '';
        }

        $tenant = trim($this->getParameter('tenant'), '\'');

        if ('' === $tenant) {
            $constraint = sprintf('%s.tenant is NULL', $targetTableAlias);
        } else {
            $constraint = sprintf('%s.tenant = \'%s\'', $targetTableAlias, $tenant);
        }

        return $constraint;
    }
}
