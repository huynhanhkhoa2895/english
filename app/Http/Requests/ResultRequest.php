<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

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
            "practice_id" => 'bail|required|max:255',
            "question_title" => 'bail|required|max:255',
            "question_type" => 'bail|required|max:255',
            "data.*.question" => 'bail|required|max:255',
            "data.*.correct_answer" => 'bail|required|max:255',
            "data.*.answer" => 'bail|required|max:255',
            "data.*.result" => 'bail|required|boolean',
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
