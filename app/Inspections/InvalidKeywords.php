<?php

namespace App\Inspections;

/**
 * Invalid keywords check
 */
class InvalidKeywords
{

    protected $keywords = [
        'yahoo customer support',
    ];

    public function detect($content)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($content, $keyword) !== false) {
                throw new \Exception('Invalid keyword input.');
            }
        }
    }
}
