<?php

namespace App\Services;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentService
{
    public function getAll($request)
    {
        $perPage = $request->per_page ? $request->per_page : 15;
        $students = Student::filter($request->all())->orderBy('id', 'asc')->paginate($perPage);
        return $students;
    }
    public function getone($id)
    {
        $student = Student::find($id);
        return $student;
    }
    public function create(array $data)
    {
        $student = Student::create([
            'full_name' => $data['full_name'],
            'code' =>$data['code'],
            'date_of_birth'=>$data['date_of_birth'],
            'email'=>$data['email'],
            'level_id'=>$data['level_id'],
            'password' => Hash::make('password'),
        ]);
        return $student;
    }

    public function update(array $data, $id)
    {
        $student = Student::find($id);
        $student->full_name = $data['full_name'];
        $student->code = $data['code'];
        $student->date_of_birth = $data['date_of_birth'];
        $student->email = $data['email'];
        $student->level_id = $data['level_id'];
        $student->save();
    }

    public function delete($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Failed to delete Student.'], 500);
        }
        $student->delete();
    }
}
