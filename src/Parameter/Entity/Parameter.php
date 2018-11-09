<?php

namespace Ds\Component\Parameter\Entity;

use Ds\Component\Encryption\Model\Type\Encryptable;
use Ds\Component\Encryption\Model\Attribute\Accessor as EncryptionAccessor;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Attribute\Accessor;

use Doctrine\ORM\Mapping as ORM;
use Ds\Component\Encryption\Model\Annotation\Encrypt;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Parameter
 *
 * @package Ds\Component\Parameter
 * @ORM\Entity(repositoryClass="Ds\Component\Parameter\Repository\ParameterRepository")
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
    use EncryptionAccessor\Encrypt;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="`key`", type="string", unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $key;

    /**
     * @var string
     * @ORM\Column(name="value", type="text", nullable=true)
     * @Encrypt("object.getEncrypt()")
     */
    private $value;

    /**
     * @var boolean
     */
    private $encrypted;

    /**
     * @var boolean
     */
    private $encrypt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->value = null;
        $this->encrypted = false;
        $this->encrypt = false;
    }
}
