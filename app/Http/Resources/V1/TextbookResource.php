<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Textbook */
class TextbookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'degree_id' => $this->degree_id,
            'degree' => new DegreeResource($this->whenLoaded('degree')),
            'language' => $this->language,
            'file' => new MediaResource($this->getFirstMedia('file')),
        ];
    }
}
