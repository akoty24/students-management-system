<?php
namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{

   public function getAll(){

       return Enrollment::all();
   }
    public function addStudents(int $courseId, array $studentIds): bool
    {
        $course = Course::find($courseId);
        if (!$course) {
            return false;
        }

        DB::transaction(function () use ($courseId, $studentIds) {
            foreach ($studentIds as $studentId) {
                Enrollment::updateOrCreate(
                    ['student_id' => $studentId, 'course_id' => $courseId]
                );
            }
        });

        return true;
    }
    public function removeStudents(int $courseId, array $studentIds): bool
    {
        $course = Course::find($courseId);
        if (!$course) {
            return false;
        }

        DB::transaction(function () use ($courseId, $studentIds) {
            Enrollment::whereIn('student_id', $studentIds)
                ->where('course_id', $courseId)
                ->delete();
        });

        return true;
    }

   
}
