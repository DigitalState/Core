<?php

namespace Ds\Component\Encryption\EventListener\Entity\Encryptable;

use Ds\Component\Encryption\Service\EncryptionService;

/**
 * Class AbstractListener
 *
 * @package Ds\Component\Encryption
 */
abstract class AbstractListener
{
    /**
     * @var \Ds\Component\Encryption\Service\EncryptionService
     */
    protected $encryptionService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Encryption\Service\EncryptionService $encryptionService
     */
    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }
}
