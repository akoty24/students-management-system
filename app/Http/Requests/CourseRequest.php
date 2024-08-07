<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateRules();
        }

        return [];
    }

    protected function createRules()
    {
        return [
            'name' => 'required|max:255',
            'code' => 'required|unique:courses',
            'description' => 'nullable|max:255',
        ];
    }

    protected function updateRules()
    {
        $courseId = $this->route('courses')->id ?? null;

        return [
            'name' => 'required|max:255',
            'code' => 'required|unique:courses,code,' . $this->id,
            'description' => 'nullable|max:255',
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
