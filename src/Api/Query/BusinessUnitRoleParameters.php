<?php

namespace Ds\Component\Api\Query;

/**
 * Class BusinessUnitRoleParameters
 *
 * @package Ds\Component\Api
 */
final class BusinessUnitRoleParameters implements Parameters
{
    use Base;

    use Attribute\BusinessUnitUuid;
    use Attribute\StaffUuid;
}
