<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\Media\MediaModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\StoreRequest;
use App\Models\Media;
use App\Traits\ApiV1Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    use ApiV1Responser;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $model = array_filter(MediaModel::cases(), fn($enum) => $enum->name === $request->model_type)[0]?->value;
            $instance = new $model;
            $record = $instance->find($request->model_id);
            Gate::authorize('update', $record);

            $createdMedia = $record->addMediaFromRequest('file')->toMediaCollection($request->collection_name);

            return $this->success($createdMedia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->error(
                [
                    'data' => __('Invalid model type'),
                    'message' => app()->environment() === 'local' ? $th->getMessage() : __('Ops! Something went wrong'),
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
    public function destroy(Media $media)
    {
        //
    }
}
