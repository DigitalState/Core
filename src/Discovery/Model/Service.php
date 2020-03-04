<?php

namespace Ds\Component\Discovery\Model;

use Ds\Component\Discovery\Model\Attribute as DiscoveryAttribute;
use Ds\Component\Model\Attribute;

/**
 * Class Service
 *
 * @package Ds\Component\Discovery
 */
final class Service
{
    use DiscoveryAttribute\Id;
    use Attribute\Ip;
    use Attribute\Port;
    use Attribute\Host;
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
