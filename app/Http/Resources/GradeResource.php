<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
 
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'grade_item' => new GradeItemResource($this->gradeItem),
            'enrollment' => new EnrollmentResource($this->enrollment),
            'score' => $this->score,           
        ];
    }
}
