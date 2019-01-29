<?php

namespace Ds\Component\Acl\Service;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Acl\Entity\Permission;
use Ds\Component\Entity\Service\EntityService;

/**
 * Class PermissionService
 *
 * @package Ds\Component\Acl
 */
final class PermissionService extends EntityService
{
    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, string $entity = Permission::class)
    {
        parent::__construct($manager, $entity);
    }
}
