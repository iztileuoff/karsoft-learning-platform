<?php

namespace App\Http\Resources\V1\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Question */
class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quiz_id' => $this->quiz_id,
            'text' => $this->text,
            'image_url' => $this->getFirstMediaUrl('image'),
            'options' => $this->getRandomOptions(),
        ];
    }
}
