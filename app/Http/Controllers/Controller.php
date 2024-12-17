<?php

namespace App\Http\Controllers;

use App\Traits\ApiV1Responser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    use ApiV1Responser;

    public function insertMany(
        Request $request,
        Model $model,
        callable $afterCreate = null,
        callable $beforeCreate = null,
    ): Response {
        $request->validate([
            'elements' => 'required|array',
        ]);

        try {
            $insertData = array_map(
                fn($element) => array_merge($element, ['created_at' => now(), 'updated_at' => now()]),
                $request->elements
            );

            if ($beforeCreate) {
                $insertData = array_map($beforeCreate, $insertData);
            }

            try {
                $model::insert($insertData);
            } catch (\Throwable $th) {
                Log::info('Cancelado!!!!!!!!', [
                    'trace' => $th->getTrace(),
                    'message' => $th->getMessage(),
                ]);
                return $this->error(
                    'Error al insertar: ' . $th->getMessage(),
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            if ($afterCreate) {
                $afterCreate($insertData);
            }

            return $this->success(
                [
                    'data' => 'created',
                    'success' => true,
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return $this->error(
                app()->hasDebugModeEnabled() ? $th->getMessage() : __('Ops! Something went wrong'),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
