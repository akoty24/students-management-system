<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Resources\Collection\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    public function index(StudentRequest $request)
    {
        $students = $this->studentService->getAll($request);

        if (!$students) {
            return response()->json(['message' => 'No students found.'], 404);
        }
        return response()->json([
            'message' => 'students retrieved successfully.',
            'students' => new StudentCollection($students)
        ]);
    }


    public function store(StudentRequest $request)
    {
        $student = $this->studentService->create($request->all());
        if (!$student) {
            return response()->json(['message' => 'Failed to create Student.'], 500);
        }
        return response()->json([
            'message' => 'Student created successfully.',
            'Student' => new StudentResource($student)
        ]);
    }


    public function update(StudentRequest $request, string $id)
    {
        $student = $this->studentService->update($request->all(), $id);
        $student = new StudentResource(Student::find($id));


        return response()->json([
            'message' => 'Student updated successfully.',
            'Student' => $student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = $this->studentService->delete($id);

        return response()->json(['message' => 'Student deleted successfully.']);
    }
}
