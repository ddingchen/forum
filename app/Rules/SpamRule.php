<?php

namespace App\Rules;

use App\Inspections\Spam;

/**
 * Rule of spam inspection
 */
class SpamRule
{

    public function passes($attribute, $value)
    {
        try {
            app(Spam::class)->detect($value);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
