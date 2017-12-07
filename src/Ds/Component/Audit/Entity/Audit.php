<?php

namespace Ds\Component\Audit\Entity;

use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Audit
 *
 * @package Ds\Component\Audit
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"method"="GET"},
 *         "post"={"method"="POST"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET"}
 *     },
 *     attributes={
 *         "normalization_context"={
 *             "groups"={"audit_output"}
 *         },
 *         "denormalization_context"={
 *             "groups"={"audit_input"}
 *         },
 *         "filters"={
 *             "ds.audit.search",
 *             "ds.audit.date",
 *             "ds.audit.order"
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Audit\Repository\AuditRepository")
 * @ORM\Table(name="ds_audit")
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class Audit implements Identifiable, Uuidentifiable, Ownable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\UserUuid;
    use Accessor\Identity;
    use Accessor\IdentityUuid;
    use Accessor\Action;
    use Accessor\Data;

    /**
     * @const string
     */
    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';
    const ACTION_DELETE = 'delete';

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"audit_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"audit_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"audit_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"audit_output"})
     */
    protected $updatedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"audit_output", "audit_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"audit_output", "audit_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"audit_output", "audit_input"})
     * @ORM\Column(name="user_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $userUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"audit_output", "audit_input"})
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $identity;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"audit_output", "audit_input"})
     * @ORM\Column(name="identity_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $identityUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"audit_output", "audit_input"})
     * @ORM\Column(name="`action`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $action;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"assessment_output", "assessment_input"})
     * @ORM\Column(name="data", type="json_array")
     * @Assert\Type("array")
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
    }
}
