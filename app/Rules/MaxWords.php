<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxWords implements ValidationRule
{


   public function __construct(protected int $max)
   {

   }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $wordCount = str_word_count($value);
        if ($wordCount > $this->max) {
            $fail("The :attribute must not exceed {$this->max} words.");
        }
    }
}
