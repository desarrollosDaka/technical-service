<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Comment\CommentableModel;
use App\Events\NewComment;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use App\Traits\ApiV1Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'commentable_type' => [
                'required',
                Rule::in(
                    array_map(fn($enum) => $enum->name, CommentableModel::cases())
                )
            ],
            'commentable_id' => 'required',
        ]);

        $record = match ($request->commentable_type) {
            CommentableModel::Ticket->name =>
            $request->user()
                ? Ticket::where('id', $request->commentable_id)->where('technical_id', $request->user()->getKey())->firstOrFail()
                : Ticket::find($request->commentable_id),
            default => null,
        };

        if ($request->user()) {
            Gate::authorize('update', $record);
        }

        return $this->success(
            QueryBuilder::for(Comment::class)
                ->allowedSorts(['created_at'])
                ->defaultSort(['-created_at'])
                ->allowedIncludes([
                    'commentator',
                    'commentable'
                ])
                ->where('commentable_id', $record->id)
                ->where('commentable_type', get_class($record))
                ->simplePaginate($request->get('perPage', 15))
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'comment' => 'required',
            'commentable_type' => [
                'required',
                Rule::in(
                    array_map(fn($enum) => $enum->name, CommentableModel::cases())
                )
            ],
            'commentable_id' => 'required',
        ]);

        $record = match ($request->commentable_type) {
            CommentableModel::Ticket->name => Ticket::find($request->commentable_id),
            default => null,
        };

        if (!$record) {
            return abort(Response::HTTP_NOT_FOUND, __('Record not found'));
        }

        Gate::authorize('update', $record);

        $comment = $record->comments()->create([
            'comment' => $request->comment,
            'commentator_id' => $request->user() ? $request->user()->getKey() : null,
            'commentator_type' => $request->user() ? get_class($request->user()) : null,
        ]);

        NewComment::dispatch($record, $comment);

        return $this->success($comment, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function externalGet(Request $request): Response
    {
        return $this->index($request);
    }
}
