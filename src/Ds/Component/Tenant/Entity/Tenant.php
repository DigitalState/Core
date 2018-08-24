<?php

namespace Ds\Component\Tenant\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Serializer\Annotation As Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tenant
 *
 * @package Ds\Component\Tenant
 * @ApiResource(
 *     shortName="system/Tenant",
 *     attributes={
 *         "normalization_context"={
 *             "groups"={"tenant_output"}
 *         },
 *         "denormalization_context"={
 *             "groups"={"tenant_input"}
 *         },
 *         "filters"={
 *             "ds_tenant.tenant.search",
 *             "ds_tenant.tenant.date",
 *             "ds_tenant.tenant.order"
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Tenant\Repository\TenantRepository")
 * @ORM\Table(name="ds_tenant")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class Tenant implements Identifiable, Uuidentifiable, Versionable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Data;
    use Accessor\Version;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"tenant_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=true)
     * @Serializer\Groups({"tenant_input", "tenant_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"tenant_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"tenant_output"})
     */
    protected $updatedAt;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"tenant_output", "tenant_input"})
     * @ORM\Column(name="data", type="json_array")
     * @Assert\Type("array")
     */
    protected $data;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"tenant_output", "tenant_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $version;
}
