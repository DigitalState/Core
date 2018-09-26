<?php

namespace Ds\Component\Encryption\Service;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use LogicException;

/**
 * Class CipherService
 *
 * @package Ds\Component\Encryption
 */
final class CipherService
{
    /**
     * @var string
     */
    private $key;

    /**
     * Constructor
     *
     * @param string $key
     */
    public function __construct(string $key = null)
    {
        $this->key = $key;
    }

    /**
     * Encrypt data using secret key
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    public function encrypt(string $data, string $key = null) : string
    {
        $key = $this->createKey($key);
        $data = Crypto::encrypt($data, $key);

        return $data;
    }

    /**
     * Decrypt data using secret key
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    public function decrypt(string $data, string $key = null) : string
    {
        $key = $this->createKey($key);
        $data = Crypto::decrypt($data, $key);

        return $data;
    }

    /**
     * Create key
     *
     * @param string $key
     * @return \Defuse\Crypto\Key
     * @throws \LogicException If the key is not defined
     */
    private function createKey(string $key = null) : Key
    {
        if (null === $key) {
            $key = $this->key;
        }

        if (null === $key) {
            throw new LogicException('Cipher secret key is not defined.');
        }

        $key = Key::loadFromAsciiSafeString($key);

        return $key;
    }
}
