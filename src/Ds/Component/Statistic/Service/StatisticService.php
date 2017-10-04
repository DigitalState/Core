<?php

namespace Ds\Component\Statistic\Service;

use Ds\Component\Statistic\Collection\StatCollection;
use Ds\Component\Statistic\Exception\InvalidAliasException;
use Ds\Component\Statistic\Model\Data;

/**
 * Class StatisticService
 *
 * @package Ds\Component\Statistic
 */
class StatisticService
{
    /**
     * @var \Ds\Component\Statistic\Collection\StatCollection
     */
    protected $statCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Statistic\Collection\StatCollection $statCollection
     */
    public function __construct(StatCollection $statCollection)
    {
        $this->statCollection = $statCollection;
    }

    /**
     * Get statistic data
     *
     * @param string $alias
     * @return \Ds\Component\Statistic\Model\Data|\Ds\Component\Statistic\Model\Datum
     * @throws \Ds\Component\Statistic\Exception\InvalidAliasException
     */
    public function get($alias = null)
    {
        if (null === $alias) {
            $data = new Data;

            foreach ($this->statCollection as $stat) {
                $datum = $stat->get();
                $data->getCollection()->add($datum);
            }

            return $data;
        } else {
            $stat = $this->statCollection->filter(function($element) use($alias) {
                return $element->getAlias() === $alias;
            })->first();

            if (!$stat) {
                throw new InvalidAliasException('Stat alias does not exist.');
            }

            $datum = $stat->get();

            return $datum;
        }
    }
}
