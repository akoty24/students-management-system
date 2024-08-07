<?php
namespace App\Services;

use App\Models\GradeItem;
use Illuminate\Http\Request;

class GradeItemService
{
    public function getAll(Request $request)
    {
        $perPage = $request->per_page ? $request->per_page : 15;
        return GradeItem::orderBy('id', 'asc')->paginate($perPage);
    }
    public function getOne($id)
    {
        return GradeItem::find($id);
    }

    public function create(array $data)
    {
        return GradeItem::create([
            'name' => $data['name'],
            'max_degree' => $data['max_degree'],
        ]);
    }

    public function update(array $data, $id)
    {
        $gradeItem = GradeItem::find($id);
        if (!$gradeItem) {
            return null;
        }
        $gradeItem->name = $data['name'];
        $gradeItem->max_degree = $data['max_degree'];
        $gradeItem->save();
        return $gradeItem;
    }


    public function delete($id)
    {
        $gradeItem = GradeItem::find($id);
        if (!$gradeItem) {
            return false;
        }
        $gradeItem->delete();
        return true;
    }
}
