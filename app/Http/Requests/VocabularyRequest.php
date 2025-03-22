<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class VocabularyRequest extends FormRequest
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
            "vocabulary" => 'bail|required|max:255',
            "translate" => 'bail|required|max:255',
            "spelling" => 'bail|max:255',
            "parts_of_speech" => 'bail|max:255',
            "priority" => 'bail|required|max:255',
            "level" => 'bail|required|max:255',
            "user_id" => 'bail|required|max:255',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => $validator->errors(),
            'errors' => 'Bad Request',
        ];

        throw new HttpResponseException(response()->json($response, 400));
    }
}
