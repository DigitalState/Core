<?php

namespace Ds\Component\Acl\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Acl\Entity\Attribute\Accessor as AclAccessor;
use Ds\Component\Model\Type\Assignable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Tenant\Model\Attribute\Accessor as TenantAccessor;
use Ds\Component\Tenant\Model\Type\Tenantable;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Access
 *
 * @package Ds\Component\Acl
 * @ApiResource(
 *      attributes={
 *          "normalization_context"={
 *              "groups"={"access_output", "permission_output"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"access_input", "permission_input"}
 *          },
 *          "filters"={
 *              "ds_acl.access.search",
 *              "ds_acl.access.date"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Acl\Repository\AccessRepository")
 * @ORM\Table(name="ds_access")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class Access implements Identifiable, Uuidentifiable, Ownable, Assignable, Versionable, Tenantable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Assignee;
    use Accessor\AssigneeUuid;
    use AclAccessor\Permissions;
    use AclAccessor\Access;
    use Accessor\Version;
    use TenantAccessor\Tenant;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"access_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"access_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    private $uuid;

    /**
     * @var \DateTime
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @Assert\DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"access_output"})
     */
    protected $updatedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    private $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="assignee", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $assignee;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="assignee_uuid", type="guid", nullable=true)
     * @Assert\Uuid
     */
    private $assigneeUuid;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\OneToMany(targetEntity="Permission", mappedBy="access", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @Assert\Valid
     */
    private $permissions;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $version;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output"})
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    private $tenant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permissions = new ArrayCollection;
    }
}
