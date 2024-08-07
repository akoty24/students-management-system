<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Filterable;
    protected $guarded = [];

    public function gradeItems()
    {
        return $this->hasMany(GradeItem::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
}
