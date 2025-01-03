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

    /**
     * Insert many records
     *
     * @param Request $request
     * @param Model $model
     * @param callable|null $afterCreate
     * @param callable|null $beforeCreate
     * @param string|null $getInsertedId
     * @return Response
     */
    public function insertMany(
        Request $request,
        Model $model,
        callable $afterCreate = null,
        callable $beforeCreate = null,
        string|callable $getInsertedId,
    ): Response {
        $elements = $request->get('elements', []);

        $failedInsert = [];
        $successInsert = [];
        $successUpdate = [];
        $insertCount = 0;
        $failedCount = 0;
        $updateCount = 0;

        try {
            foreach ($elements as $data) {
                $data['created_at'] = now();
                $data['updated_at'] = now();

                if ($beforeCreate) {
                    $data = $beforeCreate($data);
                }

                $key = is_callable($getInsertedId) ? $getInsertedId($data) : $getInsertedId;
                $modificableIdData = is_callable($getInsertedId) ? ($key . ':' . $data[$key]) : $data[$key];

                try {
                    if (!$request->get('upgradable', false)) {
                        $model::insert($data);
                        $insertCount++;
                        $successInsert[] = $modificableIdData;
                    } else {
                        $modifiedModel = $model::updateOrCreate(
                            [$key => $data[$key]],
                            $data
                        );

                        // Elemento insertado
                        if ($modifiedModel->wasRecentlyCreated) {
                            $insertCount++;
                            $successInsert[] = $modificableIdData;
                        } else {
                            // Elemento actualizado
                            $updateCount++;
                            $successUpdate[] = $modificableIdData;
                        }
                    }
                } catch (\Throwable $th) {
                    if ($getInsertedId) {
                        $failedInsert[] = $modificableIdData . ':' . substr($th->getMessage(), 0, 150);
                    }
                    $failedCount++;
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
                        'key' => is_callable($getInsertedId) ? 'MULTIPLE_CALLABLE_KEY' : $getInsertedId,
                        'success_count' => $insertCount,
                        'failed_count' => $failedCount,
                        'update_count' => $updateCount,
                        'success' => $successInsert,
                        'failed' => $failedInsert,
                        'updated' => $successUpdate
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
