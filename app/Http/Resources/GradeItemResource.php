<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'max_degree' => $this->max_degree,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d')
            // 'tasks' => TaskResource::collection($this->tasks) ?? [],

        ];
    }
}
