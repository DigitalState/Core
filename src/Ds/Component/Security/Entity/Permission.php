<?php

namespace Ds\Component\Security\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model as Behavior;
use Doctrine\Common\Collections\ArrayCollection;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class Permission
 *
 * @ApiResource(
 *      attributes={
 *          "normalization_context"={"groups"={"permission_output"}},
 *          "denormalization_context"={"groups"={"permission_input"}}
 *      }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Security\Repository\PermissionRepository")
 * @ORM\Table(name="ds_permission")
 * @ORM\HasLifecycleCallbacks
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class Permission implements Identifiable, Uuidentifiable, Ownable, Versionable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\UserUuid;
    use Accessor\Version;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"permission_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"permission_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"permission_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"permission_output"})
     */
    protected $updatedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="user_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $userUuid;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\OneToMany(targetEntity="PermissionEntry", mappedBy="permission", cascade={"persist"})
     */
    protected $entries; # region accessors

    /**
     * Add entry
     *
     * @param \Ds\Component\Security\Entity\PermissionEntry $entry
     * @return object
     */
    public function addEntry(PermissionEntry $entry)
    {
        $entry->setPermission($this);
        $this->entries->add($entry);

        return $this;
    }

    /**
     * Remove entry
     *
     * @param \Ds\Component\Security\Entity\PermissionEntry $entry
     * @return object
     */
    public function removeEntry(PermissionEntry $entry)
    {
        $this->entries->removeElement($entry);

        return $this;
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    # endregion

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection;
    }
}
