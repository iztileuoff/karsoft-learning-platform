<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\UpdateInfoRequest;
use App\Http\Resources\V1\InfoCollection;
use App\Http\Resources\V1\InfoResource;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index(Request $request): InfoCollection
    {
        $info = Info::all();

        return new InfoCollection($info);
    }

    public function show(Info $info): InfoResource
    {
        return new InfoResource($info);
    }

    public function update(UpdateInfoRequest $request, Info $info)
    {
        $info->update($request->validated());

        return new InfoResource($info);
    }
}
