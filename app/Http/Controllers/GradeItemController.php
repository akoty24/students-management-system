<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeItemRequest;
use App\Http\Resources\Collection\GradeItemCollection;
use App\Http\Resources\GradeItemResource;
use App\Models\GradeItem;
use App\Services\GradeItemService;
use Illuminate\Http\Request;

class GradeItemController extends Controller
{
    protected $gradeItemService;

    public function __construct(GradeItemService $gradeItemService)
    {
        $this->gradeItemService = $gradeItemService;
    }

    public function index(Request $request)
    {
        $gradeItems = $this->gradeItemService->getAll($request);

        if (!$gradeItems) {
            return response()->json(['message' => 'No grade items found.'], 404);
        }
        return response()->json([
            'message' => 'Grade items retrieved successfully.',
            'gradeItems' => new GradeItemCollection($gradeItems)
        ]);
    }

    public function store(GradeItemRequest $request)
    {
        $gradeItem = $this->gradeItemService->create($request->all());
        if (!$gradeItem) {
            return response()->json(['message' => 'Failed to create Grade Item.'], 500);
        }
        return response()->json([
            'message' => 'Grade item created successfully.',
            'gradeItem' => new GradeItemResource($gradeItem)
        ]);
    }

    public function update(GradeItemRequest $request, string $id)
    {
        $gradeItem = $this->gradeItemService->update($request->all(), $id);
        if (!$gradeItem) {
            return response()->json(['message' => 'Failed to update Grade Item.'], 500);
        }
        return response()->json([
            'message' => 'Grade item updated successfully.',
            'gradeItem' => new GradeItemResource($gradeItem)
        ]);
    }

    public function destroy(string $id)
    {
        $gradeItem = $this->gradeItemService->delete($id);
        if (!$gradeItem) {
            return response()->json(['message' => 'Failed to delete Grade Item.'], 500);
        }
        return response()->json(['message' => 'Grade item deleted successfully.']);
    }

}