<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class EnrollRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer|exists:students,id',
        ];
    }

    public function messages()
    {
        return [
            'student_ids.required' => 'Student IDs are required.',
            'student_ids.array' => 'Student IDs must be an array.',
            'student_ids.*.integer' => 'Each student ID must be an integer.',
            'student_ids.*.exists' => 'Each student ID must exist in the students table.',
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));
    }
}