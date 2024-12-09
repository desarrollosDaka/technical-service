<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalVisit extends Model
{
    /** @use HasFactory<\Database\Factories\TechnicalVisitsFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'ticket_id',
        'visit_date',
        'observations',
        'meta',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'visit_date' => 'date',
        'meta' => 'array',
    ];

    /**
     * Ticket de la visita
     *
     * @return BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
