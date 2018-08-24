<?php

namespace Ds\Component\Resolver\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Resolver\Exception\UnmatchedException;

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
     * @throws \Ds\Component\Resolver\Exception\UnresolvedException
     */
    public function resolve($variable)
    {
        foreach ($this as $resolver) {
            if ($resolver->isMatch($variable)) {
                return $resolver->resolve($variable);
            }
        }

        throw new UnmatchedException('Variable pattern is not valid.');
    }
}
