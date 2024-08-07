<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;

class CourseService
{
    public function getAll($request)
    {
        $perPage = $request->per_page ? $request->per_page : 15;
        return Course::orderBy('id', 'asc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Course::create($data);
    }

    public function getById($id)
    {
        return Course::find($id);
    }
    public function update(array $data, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return null;
        }
        $course->update($data);
        return $course;
    }

    public function delete($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return null;
        }
        $course->delete();
        return $course;
    }

    public function enroll($courseId, $studentIds)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return null;
        }
        $course->students()->sync($studentIds);
        return $course;
    }

    public function addGrades($courseId, $grades)
    {
        foreach ($grades as $grade) {
            Grade::updateOrCreate(
                ['enrollment_id' => $grade['enrollment_id'], 'grade_item_id' => $grade['grade_item_id']],
                ['score' => $grade['score']]
            );
        }
        return true;
    }
}
