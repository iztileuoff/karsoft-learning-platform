<?php

namespace App\Http\Resources\V1\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\School */
class SchoolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'district_id' => $this->district_id,
            'district' => new DistrictResource($this->whenLoaded('district')),
            'name' => $this->name,
        ];
    }
}
