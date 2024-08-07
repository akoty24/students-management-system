<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory,Filterable;
    protected $guarded = [];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
