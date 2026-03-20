<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastThreeFeatures implements Rule
{
    protected $fields;
    protected $fieldNames;
    protected $missingFields = [];

   

    public function passes($attribute, $value)
    {
        $filled = collect($value)->filter()->count();
        return $filled >= 3;
    }

    public function message()
    {
        return 'At least three features must be provided.';
    }
}
