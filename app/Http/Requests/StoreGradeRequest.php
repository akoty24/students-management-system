<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreGradeRequest extends FormRequest
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
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'required|integer|exists:courses,id',
            'grades' => 'required|array',
            'grades.*.grade_item_id' => 'required|integer|exists:grade_items,id',
            'grades.*.score' => 'required|numeric|min:0|max:100',

        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Student ID is required.',
            'courses.required' => 'Courses are required.',
            'courses.array' => 'Courses must be an array.',
            'courses.*.course_id.required' => 'Course ID is required.',
            'courses.*.course_id.exists' => 'Course ID must exist.',
            'courses.*.grades.required' => 'Grades are required.',
            'courses.*.grades.array' => 'Grades must be an array.',
            'courses.*.grades.*.grade_item_id.required' => 'Grade item ID is required.',
            'courses.*.grades.*.grade_item_id.exists' => 'Grade item ID must exist.',
            'courses.*.grades.*.score.required' => 'Score is required.',
            'courses.*.grades.*.score.integer' => 'Score must be an integer.',
            'courses.*.grades.*.score.min' => 'Score must be at least 0.',
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
