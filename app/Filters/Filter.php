<?php

namespace App\Filters;

/**
 * Base filter
 */
abstract class Filter
{
    protected $filters = [];

    protected $builder;

    public function apply($builder)
    {
        $this->builder = $builder;

        $this->getFilters()->filter(function ($filter) {
            return method_exists($this, $filter);
        })->each(function ($filter) {
            return $this->$filter($this->request->$filter);
        });

        return $this->builder;
    }

    protected function getFilters()
    {
        return collect($this->request->intersect($this->filters))->flip();
    }
}
