<?php

namespace App\Models;

use App\Enums\Visit\Type as VisitType;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(\App\Observers\TechnicalVisitObserver::class)]
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
        'observation',
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
            'tickets.id', // Foreign key on the Ticket table...
            'service_calls.id', // Foreign key on the ServiceCall table...
            'ticket_id',
        );
    }

    /**
     * Solicitud de repuesto
     *
     * @return HasMany
     */
    public function partRequest(): HasMany
    {
        return $this->hasMany(PartRequest::class);
    }
}
