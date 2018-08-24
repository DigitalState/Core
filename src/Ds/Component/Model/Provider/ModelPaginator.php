<?php

namespace Ds\Component\Model\Provider;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Iterator;

/**
 * Class ModelPaginator
 */
class ModelPaginator implements Iterator, Paginator
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var integer
     */
    protected $cursor;

    /**
     * @var float
     */
    protected $currentPage;

    /**
     * @var float
     */
    protected $lastPage;

    /**
     * @var float
     */
    protected $itemsPerPage;

    /**
     * @var float
     */
    protected $totalItems;

    /**
     * Constructor
     *
     * @param array $items
     * @param float $currentPage
     * @param float $lastPage
     * @param float $itemsPerPage
     * @param float $totalItems
     */
    public function __construct(array $items = [], float $currentPage, float $lastPage, float $itemsPerPage, float $totalItems)
    {
        $this->items = $items;
        $this->cursor = 0;
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalItems = $totalItems;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPage(): float
    {
        return $this->lastPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsPerPage(): float
    {
        return $this->itemsPerPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->totalItems;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->cursor = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->items[$this->cursor];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->cursor;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->cursor;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->items[$this->cursor]);
    }
}
