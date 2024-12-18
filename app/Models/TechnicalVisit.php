<?php

namespace App\Models;

use App\Enums\Visit\Type as VisitType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TechnicalVisit extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TechnicalVisitsFactory> */
    use HasFactory, SoftDeletes, InteractsWithMedia;

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
        'reprogramming',
        'type',
        'services',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'visit_date' => 'datetime',
        'meta' => 'array',
        'reprogramming' => 'array',
        'type' => VisitType::class,
        'services' => 'array',
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

    /**
     * Media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('visit')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    /**
     * Obtener el service call de la visita
     *
     * @return HasOneThrough
     */
    public function serviceCall(): HasOneThrough
    {
        return $this->hasOneThrough(
            ServiceCall::class,
            Ticket::class,
            'id', // Foreign key on the Ticket table...
            'service_calls.id', // Foreign key on the ServiceCall table...
            'ticket_id', // Local key on the TechnicalVisit table...
            'id' // Local key on the Ticket
        );
    }
}
