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
        string $getInsertedId = null,
    ): Response {
        Log::info('LLEGANDO ELEMENTOS', [
            'count' => count($request->get('elements', []))
        ]);
        $failedInsert = [];
        $successInsert = [];

        try {
            foreach ($request->elements as $data) {
                $data['created_at'] = now();
                $data['updated_at'] = now();

                if ($beforeCreate) {
                    $data = $beforeCreate($data);
                }

                try {
                    $model::insert($data);

                    if ($getInsertedId) {
                        $successInsert[] = $data[$getInsertedId] ?? '';
                    }
                } catch (\Throwable $th) {
                    if ($getInsertedId) {
                        $failedInsert[] = $data[$getInsertedId] ?? '';
                    }
                }
            }

            if ($afterCreate) {
                $afterCreate($successInsert);
            }

            return $this->success(
                [
                    'data' => 'created',
                    'success' => true,
                    'inserted' => [
                        'key' => $getInsertedId,
                        'success' => $successInsert,
                        'failed' => $failedInsert,
                    ],
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
