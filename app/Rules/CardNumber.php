<?php

namespace App\Rules;

use App\Externals\helpers\Helper;
use Illuminate\Contracts\Validation\Rule;

class CardNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return Helper::bankCardCheck($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid Card Number :attribute';
    }
}
