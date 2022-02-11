<?php

namespace App\Services\Sanitizers;

class EncodeHtml
{
    public function run($input)
    {
        return ! is_null($input) ? htmlentities($input) : null;
    }
}
