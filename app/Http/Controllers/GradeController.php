<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Http\Resources\Collection\GradeCollection;
use App\Services\GradeService;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    private $gradeService;
    public function __construct(GradeService $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    public function store(StoreGradeRequest $request)
    {
        $studentId = $request->input('student_id');
        $courseId = $request->input('course_id');
        $gradesData = $request->input('grades');

        try {
            $success = $this->gradeService->addGrades($studentId, $courseId, $gradesData);

            if (!$success) {
                return response()->json(['message' => 'Failed to add grades.'], 500);
            }

            return response()->json(['message' => 'Grades added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function getStudentsWithGrades(Request $request)
    {
        $grades = $this->gradeService->getStudentsWithGrades($request->course_id);
        return $grades;
        if (!$grades) {
            return response()->json(['message' => 'No students found for this course.'], 404);
        }

        return response()->json([
            'message' => 'Students and grades retrieved successfully.',
            'grades' =>  new GradeCollection($grades),
        ]);
    }
    public function getStudentGrades(Request $request)
    {
        $studentId = $request->input('student_id');

        if (!$studentId) {
            return response()->json(['message' => 'Student ID is required.'], 400);
        }

        $grades = $this->gradeService->getGradesByStudent($studentId);

        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this student.'], 404);
        }

        return response()->json([
            'message' => 'Grades retrieved successfully.',
            'grades' => $grades
        ]);
    }
}
