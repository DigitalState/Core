<?php

namespace Ds\Component\Acl\Entity;

use Ds\Component\Acl\Entity\Attribute\Accessor as EntityAccessor;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Tenant\Model\Attribute\Accessor as TenantAccessor;
use Ds\Component\Tenant\Model\Type\Tenantable;

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class Permission
 *
 * @package Ds\Component\Acl
 * @ORM\Entity(repositoryClass="Ds\Component\Acl\Repository\PermissionRepository")
 * @ORM\Table(name="ds_access_permission")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Permission implements Identifiable, Tenantable
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
    use TenantAccessor\Tenant;

    /**
     * @const string
     */
    const SCOPE_GENERIC = 'generic';
    const SCOPE_OBJECT = 'object';
    const SCOPE_IDENTITY = 'identity';
    const SCOPE_OWNER = 'owner';
    const SCOPE_SESSION = 'session';

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var \Ds\Component\Acl\Entity\Access
     * @ORM\ManyToOne(targetEntity="Access", inversedBy="permissions")
     * @ORM\JoinColumn(name="access_id", referencedColumnName="id")
     * @Assert\Valid
     */
    private $access;

    /**
     * @var string
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="scope", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $scope;

    /**
     * @var string
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="entity", type="string", length=255, nullable=true)
     * @Assert\Length(min=1, max=255)
     */
    private $entity;

    /**
     * @var string
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="entity_uuid", type="guid", nullable=true)
     * @Assert\Uuid
     */
    private $entityUuid;

    /**
     * @var string
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="`key`", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $key;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var array
     * @Serializer\Groups({"permission_output", "permission_input"})
     * @ORM\Column(name="attributes", type="json_array")
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Length(min=1)
     * })
     */
    private $attributes;

    /**
     * @var string
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    private $tenant;
}
