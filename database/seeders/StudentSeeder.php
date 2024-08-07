<?php

namespace Database\Seeders;

use App\Models\Nationality;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $students = [
      ['full_name' => 'Ahmed Ali', 'code' => 'stu001', 'date_of_birth' => '2000-01-01', 'email' => 'ahmed@example.com', 'password' => Hash::make('password'), 'level_id' => 1],
      ['full_name' => 'sara Ali', 'code' => 'stu002', 'date_of_birth' => '2000-01-01', 'email' => 'sara@example.com', 'password' => Hash::make('password'), 'level_id' => 2],


    ];
    foreach ($students as $student) {
      Student::create($student);
    }
  }
}
