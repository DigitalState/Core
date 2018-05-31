<?php

namespace Ds\Component\Tenant\Initializer;

/**
 * Interface Initializer
 *
 * @package Ds\Component\Tenant
 */
interface Initializer
{
    /**
     * Initialize tenant
     *
     * @param array $data
     * @return \Ds\Component\Tenant\Initializer\Initializer
     * @example Data array sample
     * <code>
     *   tenant:
     *     uuid: 2b533711-7884-4e55-93eb-21afb3c7ad28
     *
     *   user:
     *     system:
     *       uuid: 30765b53-28ed-402b-a5c3-e21e8ab377b3
     *       password: ~
     *
     *   identity:
     *     system:
     *       uuid: 3732b4fb-3796-401c-9ecb-007bc363390a
     *     admin:
     *       uuid: 4daad9ea-794c-4e88-9bed-db6ae2399e22
     *
     *   business_unit:
     *     administration:
     *       uuid: 36565c23-ed22-4dc2-bc7e-ae1ce59a727c
     * </code>
     */
    public function initialize(array $data);
}