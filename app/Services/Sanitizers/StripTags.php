<?php

namespace App\Services\Sanitizers;

class StripTags
{
    public function run($input)
    {
        return ! is_null($input) ? strip_tags($input) : null;
    }
}
