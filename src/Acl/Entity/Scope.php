<?php

namespace Ds\Component\Acl\Entity;

use Ds\Component\Acl\Entity\Attribute\Accessor;

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 *
 * @package Ds\Component\Acl
 * @ORM\Embeddable
 */
class Scope
{
    use Accessor\Entity;
    use Accessor\EntityUuid;
    use Accessor\Type;

    /**
     * @const string
     */
    const TYPE_GENERIC = 'generic';
    const TYPE_OBJECT = 'object';
    const TYPE_IDENTITY = 'identity';
    const TYPE_OWNER = 'owner';
    const TYPE_SESSION = 'session';

    /**
     * @var string
     * @Serializer\Groups({"scope_output", "scope_input"})
     * @ORM\Column(name="type", type="string", length=32, nullable=true)
     */
    private $type;

    /**
     * @var string
     * @Serializer\Groups({"scope_output", "scope_input"})
     * @ORM\Column(name="entity", type="string", length=32, nullable=true)
     */
    private $entity;

    /**
     * @var string
     * @Serializer\Groups({"scope_output", "scope_input"})
     * @ORM\Column(name="entity_uuid", type="string", length=36, nullable=true)
     */
    private $entityUuid;
}
