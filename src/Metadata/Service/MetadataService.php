<?php

namespace Ds\Component\Metadata\Service;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Metadata\Entity\Metadata;

/**
 * Class MetadataService
 *
 * @package Ds\Component\Metadata
 */
final class MetadataService extends EntityService
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $manager, string $entity = Metadata::class)
    {
        parent::__construct($manager, $entity);
    }
}
