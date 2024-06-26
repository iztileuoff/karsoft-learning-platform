<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\OptionRequest;
use App\Http\Resources\V1\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $options = Option::paginate($request->input('per_page', 10));

        return OptionResource::collection($options);
    }

    public function store(OptionRequest $request)
    {
        return new OptionResource(Option::create($request->validated()));
    }

    public function show(Option $option)
    {
        return new OptionResource($option);
    }

    public function update(OptionRequest $request, Option $option)
    {
        $option->update($request->validated());

        return new OptionResource($option);
    }

    public function destroy(Option $option)
    {
        $option->delete();

        return response()->json();
    }
}
