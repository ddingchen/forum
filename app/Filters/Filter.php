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

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    protected function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }
}
