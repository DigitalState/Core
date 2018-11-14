<?php

namespace Ds\Component\Form\Model;

use Ds\Component\Model\Attribute;
use stdClass;

/**
 * Class Form
 *
 * @package Ds\Component\Form
 */
final class Form
{
    use Attribute\Id;
    use Attribute\Method;
    use Attribute\Action;
    use Attribute\Type;
    use Attribute\Display;
    use Attribute\Schema;
    use Attribute\Data;
    use Attribute\Primary;

    /**
     * @const integer
     */
    const TYPE_FORMIO = 'formio';
    const TYPE_SYMFONY = 'symfony';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
        $this->primary = false;
    }

    /**
     * Typecast to object
     *
     * @return \stdClass
     */
    public function toObject(): stdClass
    {
        return (object) get_object_vars($this);
    }
}
