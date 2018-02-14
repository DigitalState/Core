<?php

namespace Ds\Component\Security\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Security\Entity\Attribute\Accessor as EntityAccessor;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Ds\Component\Security\Model\Type\Secured;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class Permission
 *
 * @package Ds\Component\Security
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
 * @ORM\Entity(repositoryClass="Ds\Component\Security\Repository\PermissionRepository")
 * @ORM\Table(name="ds_access_permission")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Permission implements Identifiable, Secured
{
    use Accessor\Id;
    use Accessor\Entity;
    use Accessor\EntityUuid;
    use Accessor\Scope;
    use EntityAccessor\Access;
    use Accessor\Key;
    use Accessor\Type;
    use Accessor\Value;
    use Accessor\Attributes;

    /**
     * @const string
     */
    const SCOPE_IDENTITY = 'identity';
    const SCOPE_OWNER = 'owner';

    /**
     * @var integer
     * @ApiProperty(identifier=false, readable=false, writable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var \Ds\Component\Security\Entity\Access
     * @ApiProperty(readable=false, writable=false)
     * @ORM\ManyToOne(targetEntity="Access", inversedBy="permissions")
     * @ORM\JoinColumn(name="access_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $access;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="scope", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $scope;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="entity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $entity;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="entity_uuid", type="guid", nullable=true)
     * @Assert\Uuid
     */
    protected $entityUuid;

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
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $value;

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
