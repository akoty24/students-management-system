<?php

namespace App\Services;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelService
{
    public function getAll($request)
    {
        $perPage = $request->per_page ? $request->per_page : 15;
        return Level::orderBy('id', 'asc')->paginate($perPage);
    }
public function getById($id)
    {
        return Level::find($id);
    }
    public function create(array $data)
    {
        return Level::create($data);
    }

    public function update(array $data, $id)
    {
        $level = Level::find($id);
        if (!$level) {
            return null;
        }
        $level->update($data);
        return $level;
    }

    public function delete($id)
    {
        $level = Level::find($id);
        if (!$level) {
            return null;
        }
        $level->delete();
        return $level;
    }
}

