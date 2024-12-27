<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Media\MediaModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\IndexRequest;
use App\Http\Requests\Media\StoreRequest;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * Verifica la permisología sobre un modelo
     *
     * @param Request $request
     * @return Model
     */
    private function permissionsOnModel(Request $request, bool $validate = true): Model
    {
        $model = array_values(array_filter(MediaModel::cases(), fn($enum) => $enum->name === $request->model_type))[0]->value;
        $instance = new $model;
        $record = $instance->find($request->model_id);

        if ($validate) {
            Gate::authorize('update', $record);
        }

        return $record;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $record = $this->permissionsOnModel($request);

        return $this->success(
            $record->getMedia($request->get('collection_name', '*')),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $createdMedia = $this->permissionsOnModel($request)
                ->addMediaFromRequest('file')
                ->toMediaCollection($request->get('collection_name', 'Default'));

            return $this->success($createdMedia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            $isError = $th->getCode() >= 400 || $th->getCode() <= 505;
            return $this->error(
                [
                    'data' => __('Invalid model type'),
                    'message' => $isError ? $th->getMessage() : __('Ops! Something went wrong'),
                    'success' => false,
                    'tracer' => config('app.debug') ? $th->getTrace() : __('Ops! Something went wrong'),
                ],
                $isError ? $th->getCode() :  Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndexRequest $request, string $media): Response
    {
        $this->permissionsOnModel($request);
        return $this->success(Media::find($media)->delete());
    }

    /**
     * External Get
     *
     * @param Request $request
     * @return Response
     */
    public function externalGet(Request $request): Response
    {
        $record = $this->permissionsOnModel($request, false);

        return $this->success(
            $record->getMedia($request->get('collection_name', '*')),
        );
    }
}
