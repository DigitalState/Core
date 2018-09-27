<?php

namespace Ds\Component\Config\Entity;

use Ds\Component\Encryption\Model\Type\Encryptable;
use Ds\Component\Encryption\Model\Attribute\Accessor as EncryptionAccessor;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Attribute\Accessor;

use Doctrine\ORM\Mapping as ORM;
use Ds\Component\Encryption\Model\Annotation\Encrypt;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Config
 *
 * @package Ds\Component\Config
 * @ORM\Entity(repositoryClass="Ds\Component\Config\Repository\ParameterRepository")
 * @ORM\Table(name="ds_parameter")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="key")
 */
class Parameter implements Identifiable, Encryptable
{
    use Accessor\Id;
    use Accessor\Key;
    use Accessor\Value;
    use EncryptionAccessor\Encrypted;
    use Accessor\Enabled;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="`key`", type="string", unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $key;

    /**
     * @var string
     * @ORM\Column(name="value", type="json_array", nullable=true)
     * @Encrypt("object.getEncrypted()")
     */
    protected $value;

    /**
     * @var boolean
     * @ORM\Column(name="encrypted", type="boolean")
     * @Assert\Type("boolean")
     */
    protected $encrypted;

    /**
     * @var string
     * @ORM\Column(name="enabled", type="boolean")
     * @Assert\Type("boolean")
     */
    protected $enabled;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->value = null;
        $this->encrypted = false;
        $this->enabled = false;
    }
}
