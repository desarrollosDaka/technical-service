<?php

namespace App\Models;

use App\Enums\Ticket\Status as TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'technical_id',
        'service_call_id',
        'title',
        'diagnosis_date',
        'diagnosis_detail',
        'solution_date',
        'solution_detail',
        'customer_name',
        'status',
        'total_cost',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'status' => TicketStatus::class,
        'diagnosis_date' => 'datetime',
        'solution_date' => 'datetime',
        'total_cost' => 'float',
    ];

    /**
     * Técnico encargado del ticket
     *
     * @return BelongsTo
     */
    public function technical(): BelongsTo
    {
        return $this->belongsTo(Technical::class);
    }

    /**
     * Data maestra original. Service Call
     *
     * @return BelongsTo
     */
    public function serviceCall(): BelongsTo
    {
        return $this->belongsTo(ServiceCall::class);
    }
}
