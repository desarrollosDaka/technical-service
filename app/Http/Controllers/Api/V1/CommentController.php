<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\Comment\CommentableModel;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use App\Traits\ApiV1Responser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    use ApiV1Responser;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required',
        ]);

        return $this->success(
            QueryBuilder::for(Comment::class)
                ->allowedSorts(['created_at'])
                ->defaultSort(['-created_at'])
                ->allowedIncludes(['commentator'])
                ->where('commentable_id', $request->ticket_id)
                ->where('commentable_type', Ticket::class)
                ->simplePaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        $comment = $record->comments()->create([
            'comment' => $request->comment,
            'commentator_id' => $request->user() ? $request->user()->getKey() : null,
            'commentator_type' => $request->user() ? get_class($request->user()) : null,
        ]);

        return $this->success($comment, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
