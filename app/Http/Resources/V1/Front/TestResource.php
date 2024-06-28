<?php

namespace App\Http\Resources\V1\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Test */
class TestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'quiz_id' => $this->quiz_id,
            'user_id' => $this->user_id,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'time_spent' => $this->time_spent,
            'questions_count' => $this->questions_count,
            'correct_questions_count' => $this->correct_questions_count,
            'data_questions' => $this->data_questions,
        ];
    }
}
