<?php

namespace Ds\Component\Config\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class Config
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"method"="GET"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET"},
 *         "put"={"method"="PUT"}
 *     },
 *     attributes={
 *         "filters"={"ds.config.search", "ds.config.date", "ds.config.boolean"},
 *         "normalization_context"={"groups"={"config_output"}},
 *         "denormalization_context"={"groups"={"config_input"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass="Ds\Component\Config\Repository\ConfigRepository")
 * @ORM\Table(name="ds_config")
 * @ORM\HasLifecycleCallbacks
 * @ORMAssert\UniqueEntity(fields="uuid")
 * @ORMAssert\UniqueEntity(fields="key")
 */
class Config implements Identifiable, Uuidentifiable, Ownable, Versionable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Key;
    use Accessor\Value;
    use Accessor\Enabled;
    use Accessor\Version;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"config_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"config_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"config_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"config_output"})
     */
    protected $updatedAt;

    /**
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"config_output"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $owner;

    /**
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"config_output"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"config_output"})
     * @ORM\Column(name="`key`", type="string", unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $key;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"config_output", "config_input"})
     * @ORM\Column(name="`value`", type="text", nullable=true)
     */
    protected $value;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"config_output", "config_input"})
     * @ORM\Column(name="enabled", type="boolean")
     * @Assert\Type("boolean")
     */
    protected $enabled;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"config_output", "config_input"})
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
        $this->value = null;
        $this->enabled = false;
    }
}
