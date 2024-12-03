<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Login por medio de sanctum
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        return response()->json([
            'status' => Response::HTTP_OK,
        ]);
    }
}
