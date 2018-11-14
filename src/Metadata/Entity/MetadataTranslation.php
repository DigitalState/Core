<?php

namespace Ds\Component\Metadata\Entity;

use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model as Behavior;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MetadataTranslation
 *
 * @package Ds\Component\Metadata
 * @ORM\Entity
 * @ORM\Table(name="ds_metadata_trans")
 */
class MetadataTranslation
{
    use Behavior\Translatable\Translation;

    use Accessor\Title;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
}
