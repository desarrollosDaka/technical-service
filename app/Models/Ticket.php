<?php

namespace App\Models;

use App\Enums\Ticket\Status as TicketStatus;
use App\Livewire\Ticket\Qualify;
use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(\App\Observers\TicketObserver::class)]
class Ticket extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, SoftDeletes, Commentable, InteractsWithMedia;

    public static ?Ticket $instance = null;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'technical_id',
        'service_call_id',
        'diagnosis_date',
        'diagnosis_detail',
        'solution_date',
        'solution_detail',
        'reject_date',
        'reject_detail',
        'customer_name',
        'status',
        'total_cost',
        'meta',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
        'status' => TicketStatus::class,
        'diagnosis_date' => 'datetime',
        'solution_date' => 'datetime',
        'reject_date' => 'datetime',
        'total_cost' => 'float',
    ];

    /**
     * Current ticket en el front de usuarios
     *
     * @return Ticket|null
     */
    public static function current(): ?Ticket
    {
        if (self::$instance) {
            return self::$instance;
        }

        if (!ServiceCall::current()) {
            return null;
        }

        return self::$instance = self::where('service_call_id', ServiceCall::current()->id)
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('diagnostic')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('closed')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    /**
     * Técnico encargado del ticket
     *
     * @return BelongsTo
     */
    public function technical(): BelongsTo
    {
        return $this->belongsTo(Technical::class, 'technical_id');
    }

    /**
     * Data maestra original. Service Call
     *
     * @return BelongsTo
     */
    public function serviceCall(): BelongsTo
    {
        return $this->belongsTo(ServiceCall::class, 'service_call_id');
    }

    /**
     * Visitas realizadas en este ticket
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(TechnicalVisit::class);
    }

    /**
     * Calificación del soporte
     *
     * @return void
     */
    public function qualify(): HasOne
    {
        return $this->hasOne(QualifySupport::class);
    }

    /**
     * Request de partes
     *
     * @return HasManyThrough
     */
    public function partRequest(): HasManyThrough
    {
        return $this->hasManyThrough(PartRequest::class, TechnicalVisit::class);
    }
}
