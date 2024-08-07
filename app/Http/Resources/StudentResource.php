<?php

namespace App\Http\Resources;

use App\Http\Resources\Collection\CourseCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'full_name' => $this->full_name,
            'code' => $this->code,
            'date_of_birth' => $this->date_of_birth,
            'level_id' => $this->level_id,
            'email' => $this->email,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),

            // 'tasks' => TaskResource::collection($this->tasks) ?? [],

        ];
    }
}
