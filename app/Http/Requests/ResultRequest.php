<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "data.*.question" => 'bail|required|max:255',
            "data.*.correct_answer" => 'bail|required|max:255',
            "data.*.answer" => 'bail|required|max:255',
            "data.*.result" => 'bail|required|boolean',
        ];
    }
}
