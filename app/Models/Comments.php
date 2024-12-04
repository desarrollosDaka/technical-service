<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    /** @use HasFactory<\Database\Factories\CommentsFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'commentator_model',
        'commentator_id',
        'comment',
    ];

    /**
     * Modelo sobre el que se puede aplicar un comentario
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Persona (técnico) que hizo el comentario.
     * Puede estar vació, para usuario sin sesión.
     *
     * @return MorphTo
     */
    public function commentator(): MorphTo
    {
        return $this->morphTo();
    }
}
