<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'level 1', 'number' => 1, 'description' => 'description for level 1'],
            ['name' => 'level 2', 'number' => 2, 'description' => 'description for level 2'],
            ['name' => 'level 3', 'number' => 3, 'description' => 'description for level 3'],
            ['name' => 'level 4', 'number' => 4, 'description' => 'description for level 4'],

        ];
        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
