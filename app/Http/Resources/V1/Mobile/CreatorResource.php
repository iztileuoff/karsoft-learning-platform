<?php

namespace App\Http\Resources\V1\Mobile;

use App\Http\Resources\V1\Admin\DistrictResource;
use App\Http\Resources\V1\Admin\PostResource;
use App\Http\Resources\V1\Admin\RegionResource;
use App\Http\Resources\V1\Admin\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class CreatorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
        ];
    }
}
