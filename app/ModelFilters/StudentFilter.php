<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StudentFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
    public function search($query)
    {
        return $this->where(function ($q) use ($query) {
            $q->where('full_name', 'like', "%$query%")
              ->orWhere('code', 'like', "%$query%")
              ->orWhere('email', 'like', "%$query%");
        });
    }
    public function name($name)
    {
        return $this->where('full_name', 'like', "%$name%");
    }

    public function code($code)
    {
        return $this->where('code', 'like', "%$code%");
    }

    public function email($email)
    {
        return $this->where('email', 'like', "%$email%");
    }
    public function level($level)
    {
        return $this->whereHas('level', function ($q) use ($level) {
            $q->where('name', 'like', "%$level%");
        });
    }
}
