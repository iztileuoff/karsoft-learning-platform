<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\InfoResource;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __invoke(Request $request): InfoResource
    {
        $info = Info::where('mobile', true)->first();

        return new InfoResource($info);
    }
}
