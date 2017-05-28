<?php

namespace Ds\Component\Config\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Accessor;
use Ds\Component\Config\Accessor as ConfigAccessor;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class Config
 *
 * @ORM\Entity(repositoryClass="Ds\Component\Config\Repository\ConfigRepository")
 * @ORM\Table(name="ds_config")
 * @ORM\HasLifecycleCallbacks
 * @ORMAssert\UniqueEntity(fields="key")
 */
class Config implements Identifiable
{
    use Accessor\Id;
    use ConfigAccessor\Key;
    use ConfigAccessor\Value;
    use ConfigAccessor\Fallback;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="`key`", type="string")
     * @Assert\NotBlank
     */
    protected $key;

    /**
     * @var string
     * @ORM\Column(name="`value`", type="text", nullable=true)
     */
    protected $value;

    /**
     * @var string
     * @ORM\Column(name="fallback", type="boolean")
     */
    protected $fallback;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->value = null;
        $this->fallback = true;
    }
}
