<?php

namespace App\Inspections;

/**
 * Spam
 */
class Spam
{

    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    public function detect($content)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($content);
        }

        return false;
    }
}
