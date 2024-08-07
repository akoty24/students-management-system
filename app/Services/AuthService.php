<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data)
    {
        $student = Student::create([
            'full_name' => $data['full_name'],
            'code' =>$data['code'],
            'date_of_birth'=>$data['date_of_birth'],
            'email'=>$data['email'],
            'level_id'=>$data['level_id'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $student->createToken('default')->plainTextToken;

        return ['student' => $student, 'token' => $token];
    }

    public function login(array $data)
    {
        $student = Student::where('email', $data['email'])->first();

        if (!$student || !Hash::check($data['password'], $student->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $student->createToken('default')->plainTextToken;
    }

    public function logout(Student $student)
    {
        $student->tokens()->delete();
    }
}
