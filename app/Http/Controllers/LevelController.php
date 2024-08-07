<?php
namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use App\Http\Resources\Collection\LevelCollection;
use App\Http\Resources\LevelResource;
use App\Models\Level;
use App\Services\LevelService;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    protected $levelService;

    public function __construct(LevelService $levelService)
    {
        $this->levelService = $levelService;
    }

    public function index(Request $request)
    {
        $levels = $this->levelService->getAll($request);

        if (!$levels) {
            return response()->json(['message' => 'No levels found.'], 404);
        }
        return response()->json([
            'message' => 'Levels retrieved successfully.',
            'levels' => new LevelCollection($levels)
        ]);
    }
    public function show(string $id)
      {
        $level = $this->levelService->getById($id);
        if (!$level) {
            return response()->json(['message' => 'Level not found.'], 404);
        }
        return response()->json([
            'message' => 'Level retrieved successfully.',
            'level' => new LevelResource($level)
        ]);
    }
    public function store(LevelRequest $request)
    {
        $level = $this->levelService->create($request->all());
        if (!$level) {
            return response()->json(['message' => 'Failed to create Level.'], 500);
        }
        return response()->json([
            'message' => 'Level created successfully.',
            'level' => new LevelResource($level)
        ]);
    }

    public function update(LevelRequest $request, string $id)
    {
        $level = $this->levelService->update($request->all(), $id);
        if (!$level) {
            return response()->json(['message' => 'Failed to update Level.'], 500);
        }
        return response()->json([
            'message' => 'Level updated successfully.',
            'level' => new LevelResource($level)
        ]);
    }

    public function destroy(string $id)
    {
        $level = $this->levelService->delete($id);
        if (!$level) {
            return response()->json(['message' => 'Failed to delete Level.'], 500);
        }
        return response()->json(['message' => 'Level deleted successfully.']);
    }
}
