<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student  extends Authenticatable
{
//, Filterable
 use HasApiTokens, HasFactory, Notifiable , Filterable;
     protected $guarded = [];


    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
}
