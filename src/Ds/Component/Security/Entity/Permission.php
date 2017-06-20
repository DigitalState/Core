<?php

namespace Ds\Component\Security\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Security\Model\Attribute\Accessor as SecurityAccessor;
use Knp\DoctrineBehaviors\Model as Behavior;

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
class Permission implements Identifiable, Uuidentifiable, Ownable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\UserUuid;
    use SecurityAccessor\Key;
    use SecurityAccessor\Attributes;

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
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="`key`", type="string", length=255)
     * @Assert\NotBlank
     */
    protected $key;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="attributes", type="json_array")
     * @Assert\NotBlank
     */
    protected $attributes;
}
