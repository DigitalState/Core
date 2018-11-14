<?php

namespace Ds\Component\Association\Entity;

use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Model\Type\Associable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Tenant\Model\Attribute\Accessor as TenantAccessor;
use Ds\Component\Tenant\Model\Type\Tenantable;
use Knp\DoctrineBehaviors\Model As Behavior;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Association
 *
 * @package Ds\Component\Association
 */
abstract class Association implements Identifiable, Uuidentifiable, Associable, Ownable, Versionable, Tenantable
{
    use Behavior\Timestampable\Timestampable;
    use Behavior\SoftDeletable\SoftDeletable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Entity;
    use Accessor\EntityUuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Version;
    use TenantAccessor\Tenant;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"association_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"association_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"association_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"association_output"})
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"association_output"})
     */
    protected $deletedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"association_output", "association_input"})
     * @ORM\Column(name="entity", type="string")
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $entity;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"association_output", "association_input"})
     * @ORM\Column(name="entity_uuid", type="guid")
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $entityUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"association_output", "association_input"})
     * @ORM\Column(name="`owner`", type="string")
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"association_output", "association_input"})
     * @ORM\Column(name="owner_uuid", type="guid")
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"association_output", "association_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $version;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"association_output"})
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    protected $tenant;
}
