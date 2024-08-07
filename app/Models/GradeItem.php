<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeItem extends Model
{
    use HasFactory,Filterable;
    protected $guarded = [];


    public function course()
    {
        return $this->belongsTo(Course::class, 'enrollments');
    }
    public function grades()
    {
        return $this->hasMany(Grade::class,);
    }
}
