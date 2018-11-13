<?php

namespace Ds\Component\Formio\Model;

use stdClass;

/**
 * Class Project
 *
 * @package Ds\Component\Formio
 */
final class Project implements Model
{
    use Attribute\Id;
    use Attribute\Title;
    use Attribute\Name;
    use Attribute\Description;
    use Attribute\Template;
    use Attribute\Settings;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->settings = new stdClass;
    }
}
