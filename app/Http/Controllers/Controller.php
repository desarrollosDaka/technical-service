<?php

namespace App\Http\Controllers;

use App\Traits\ApiV1Responser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    use ApiV1Responser;

    public function insertMany(Request $request, Model $model): Response
    {
        $request->validate([
            'elements' => 'required|array',
        ]);

        try {
            $model::insert(
                array_map(
                    fn($element) => array_merge($element, ['created_at' => now(), 'updated_at' => now()]),
                    $request->elements
                )
            );

            return $this->success(['data' => 'created'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->error(
                app()->hasDebugModeEnabled() ? $th->getMessage() : __('Ops! Something went wrong'),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
