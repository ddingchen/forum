<?php

namespace App\Inspections;

/**
 * Key held down check
 */
class KeyHeldDown
{

    public function detect($content)
    {
        if (preg_match('/(.){4,}/', $content)) {
            throw new \Exception;
        }
    }
}
