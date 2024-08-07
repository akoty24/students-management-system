<?php

namespace Database\Seeders;

use App\Models\GradeItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gradeItems = [
            ['name' => 'practical exam', 'max_degree' => 25,],
            ['name' => 'oral exam', 'max_degree' => 25,],
            ['name' => 'midterm exam', 'max_degree' => 50,],
            ['name' => 'final exam', 'max_degree' => 100,],

        ];
        foreach ($gradeItems as $gradeItem) {
            GradeItem::create($gradeItem);
        }
    }
}
