<?php

namespace Ds\Component\Security\Entity;

use Ds\Component\Model\Type\Assignable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Security\Model\Type\Secured;
use Ds\Component\Tenant\Model\Attribute\Accessor as TenantAccessor;
use Ds\Component\Tenant\Model\Type\Tenantable;
use Knp\DoctrineBehaviors\Model as Behavior;
use Doctrine\Common\Collections\ArrayCollection;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class Access
 *
 * @package Ds\Component\Security
 * @ApiResource(
 *      attributes={
 *          "normalization_context"={
 *              "groups"={"access_output", "permission_output"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"access_input", "permission_input"}
 *          },
 *          "filters"={
 *              "ds_security.access.search",
 *              "ds_security.access.date"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Security\Repository\AccessRepository")
 * @ORM\Table(name="ds_access")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class Access implements Identifiable, Uuidentifiable, Ownable, Assignable, Versionable, Tenantable, Secured
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Assignee;
    use Accessor\AssigneeUuid;
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
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"access_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"access_output"})
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
    protected $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="assignee", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $assignee;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="assignee_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $assigneeUuid;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\OneToMany(targetEntity="Permission", mappedBy="access", cascade={"persist", "remove"})
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @Assert\Valid
     */
    protected $permissions; # region accessors

    /**
     * Set permissions
     *
     * @return object
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Add permission
     *
     * @param \Ds\Component\Security\Entity\Permission $permission
     * @return object
     */
    public function addPermission(Permission $permission)
    {
        $permission->setAccess($this);
        $this->permissions->add($permission);

        return $this;
    }

    /**
     * Remove permission
     *
     * @param \Ds\Component\Security\Entity\Permission $permission
     * @return object
     */
    public function removePermission(Permission $permission)
    {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    # endregion

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"access_output", "access_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $version;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"access_output"})
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    protected $tenant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permissions = new ArrayCollection;
    }
}
