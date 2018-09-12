<?php

namespace Ds\Component\Discovery\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Service
 *
 * @package Ds\Component\Discovery
 */
class Service
{
    use Attribute\Id;
    use Attribute\Ip;
    use Attribute\Port;
    use Attribute\Meta;
    use Attribute\Tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meta = [];
        $this->tags = [];
    }
}
