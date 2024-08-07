<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'mathematics', 'code' =>'course001', 'description' => 'description for mathematics'],
            ['name' => 'science', 'code' => 'course002', 'description' => 'description for science'],
            ['name' => 'CS', 'code' => 'course003', 'description' => 'description for CS'],
         

        ];
        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
