<?php

namespace Ds\Component\Security\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Security\Model\Attribute\Accessor as SecurityAccessor;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class PermissionEntry
 *
 * @ApiResource(
 *      attributes={
 *          "normalization_context"={
 *              "groups"={"permission_output"}
 *          },
 *          "denormalization_context"={
 *              "groups"={"permission_input"}
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Security\Repository\PermissionEntryRepository")
 * @ORM\Table(name="ds_permission_entry")
 * @ORM\HasLifecycleCallbacks
 */
class PermissionEntry implements Identifiable
{
    use Accessor\Id;
    use Accessor\BusinessUnitUuid;
    use SecurityAccessor\Key;
    use SecurityAccessor\Attributes;

    /**
     * @var integer
     * @ApiProperty(identifier=false, readable=false, writable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var \Ds\Component\Security\Entity\Permission
     * @ApiProperty(readable=false, writable=false)
     * @ORM\ManyToOne(targetEntity="Permission", inversedBy="entries")
     * @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $permission; # region accessors

    /**
     * Set permission
     *
     * @param \Ds\Component\Security\Entity\Permission $permission
     * @return object
     */
    public function setPermission(Permission $permission = null)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return \Ds\Component\Security\Entity\Permission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    # endregion

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="business_unit_uuid", type="guid", nullable=true)
     * @Assert\Uuid
     */
    protected $businessUnitUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="`key`", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $key;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="attributes", type="json_array")
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Length(min=1)
     * })
     */
    protected $attributes;
}
