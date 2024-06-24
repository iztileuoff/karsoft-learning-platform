<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->ok();
    }
}
