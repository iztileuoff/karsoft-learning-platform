<?php

namespace App\Http\Resources\V1\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Test */
class TestAnswerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'started_at' => $this->started_at?->format('Y-m-d H:i:s'),
            'finished_at' => $this->finished_at?->format('Y-m-d H:i:s'),
            'time_spent' => $this->time_spent,
            'questions_count' => $this->questions_count,
            'correct_answers_count' => $this->correct_answers_count,
            'percent' => $this->percent,
            'answers' => $this->data_questions,
        ];
    }
}
