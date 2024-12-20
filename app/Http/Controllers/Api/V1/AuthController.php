<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiV1Responser;
use App\Http\Controllers\Controller;
use App\Models\Technical;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Login por medio de sanctum
     *
     * @param Request $request
     * @return HttpResponse
     */
    public function login(Request $request): HttpResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $technical = Technical::where('Email', $validated['email'])->first();

            if (!$technical || !Hash::check($validated['password'], $technical->Password)) {
                throw new Exception(__('The provided credentials are incorrect.'));
            }

            return $this->success([
                'token' => $technical->createToken($validated['email'])->plainTextToken
            ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Current user
     *
     * @param Request $request
     * @return HttpResponse
     */
    public function user(Request $request): HttpResponse
    {
        return $this->success($request->user());
    }

    /**
     * Actualizado
     *
     * @param Request $request
     * @return HttpResponse
     */
    public function update(Request $request): HttpResponse
    {
        $validated = $request->validate([
            'User_name' => 'nullable|max:255',
            'Email' => 'nullable|max:255',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'Address' => 'nullable',
            'Phone' => 'nullable',
        ]);

        $request->user()->update($validated);

        return $this->success($request->user());
    }
}
