<?php

namespace Ds\Component\Bpm\Resolver;

use DomainException;

/**
 * Class BpmResolver
 */
class BpmResolver extends AbstractResolver
{
    /**
     * @const string
     */
    const PATTERN = '/^ds\.context\.bpm\.(.+)/';

    /**
     * {@inheritdoc}
     */
    public function resolve($variable)
    {
        if (!preg_match(static::PATTERN, $variable, $matches)) {
            throw new DomainException('Variable pattern is not valid.');
        }

        $value = 12222;

        return $value;
    }
}
