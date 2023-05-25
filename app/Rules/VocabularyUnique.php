<?php

namespace App\Rules;

use App\Interface\VocabularyInterface;
use App\Services\VocabularyService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VocabularyUnique implements ValidationRule
{
    public function __construct(private $data){

    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sv = app(VocabularyInterface::class);
        if(!$sv->validateVocabulary($this->data['vocabulary'],$this->data['parts_of_speech'],$this->data['id'])){
            $fail("The {$attribute} is exist.");
        }
    }
}
