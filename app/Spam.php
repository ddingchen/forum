<?php

namespace App;

/**
 * Spam
 */
class Spam
{

    public function detect($content)
    {
        $this->detectInvalidKeywords($content);

        return false;
    }

    protected function detectInvalidKeywords($content)
    {
        $invalidKeywords = [
            'yahoo customer support',
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($content, $keyword) !== false) {
                throw new \Exception;
            }
        }
    }
}
