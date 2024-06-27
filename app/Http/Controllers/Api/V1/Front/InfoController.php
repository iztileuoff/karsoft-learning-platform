<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Front\InfoResource;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __invoke(Request $request): InfoResource
    {
        $info = Info::where('mobile', false)->first();

        return new InfoResource($info);
    }
}
