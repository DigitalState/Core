<?php

namespace Ds\Component\Resolver\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use DomainException;

/**
 * Class ResolverCollection
 */
class ResolverCollection extends ArrayCollection
{
    /**
     * Get value
     *
     * @param string $variable
     * @return mixed
     * @throws \DomainException
     */
    public function resolve($variable)
    {
        foreach ($this as $resolver) {
            if ($resolver->isMatch($variable)) {
                return $resolver->get($variable);
            }
        }

        throw new DomainException('Variable pattern is not valid.');
    }
}
