<?php

namespace App\Http\Requests\Concerns;

use App\Services\Sanitizers\StripTags;
use App\Services\Sanitizers\EncodeHtml;

trait SanitizesInput
{
    protected function fieldsToSanitize()
    {
        return [
        ];
    }

    protected function defaultSanitizers()
    {
        return [
            StripTags::class,
            EncodeHtml::class,
        ];
    }

    public function passedValidation()
    {
        foreach ($this->fieldsToSanitize() as $key => $value) {
            $sanitizers = is_array($value) ? $value : $this->defaultSanitizers();
            $field = is_array($value) ? $key : $value;

            foreach ($sanitizers as $sanitizer) {
                $this->merge([
                    $field = (new $sanitizer)->run($this->{$field})
                ]);
            }
        }
    }
}
