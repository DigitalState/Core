<?php

namespace Ds\Component\Formio\Model;

/**
 * Class Role
 *
 * @package Ds\Component\Formio
 */
final class Role implements Model
{
    use Attribute\Id;
    use Attribute\Created;
    use Attribute\Updated;
    use Attribute\Title;
    use Attribute\MachineName;
    use Attribute\Description;
    use Attribute\Admin;
    use Attribute\DefaultAttribute;
}
