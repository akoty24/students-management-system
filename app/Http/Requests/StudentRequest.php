<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class StudentRequest extends FormRequest
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
            'full_name' => 'required|max:255',
            'code' => 'required',
            'date_of_birth' => 'required|date',
            'level_id' => 'required',
            'email' => 'required|string|email|max:255|unique:students',
           // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    protected function updateRules()
    {
        $studentId = $this->route('students')->id ?? null;

        return [
    
            'full_name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:students,code,' . $this->id,
        'date_of_birth' => 'required|date',
        'email' => 'required|email|unique:students,email,' . $this->id,
        'level_id' => 'required|exists:levels,id',
           // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
