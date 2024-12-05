<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Media\MediaModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\IndexRequest;
use App\Http\Requests\Media\StoreRequest;
use App\Models\Media;
use App\Traits\ApiV1Responser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    use ApiV1Responser;

    /**
     * Verifica la permisología sobre un modelo
     *
     * @param Request $request
     * @return Model
     */
    private function permissionsOnModel(Request $request): Model
    {
        $model = array_filter(MediaModel::cases(), fn($enum) => $enum->name === $request->model_type)[0]?->value;
        $instance = new $model;
        $record = $instance->find($request->model_id);
        Gate::authorize('update', $record);

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
                ->toMediaCollection($request->collection_name);

            return $this->success($createdMedia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->error(
                [
                    'data' => __('Invalid model type'),
                    'message' => config('app.debug') ? $th->getMessage() : __('Ops! Something went wrong'),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndexRequest $request, string $media)
    {
        $this->permissionsOnModel($request);
        return $this->success(Media::find($media)->delete());
    }
}
