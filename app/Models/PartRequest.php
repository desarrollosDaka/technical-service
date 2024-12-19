<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PartRequest\Status as PartRequestStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(\App\Observers\PartRequestObserver::class)]
class PartRequest extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'status',
        'technical_visit_id',
        'observation',
        'date_handed',
        'meta',
    ];

    protected $casts = [
        'status' => PartRequestStatus::class,
        'meta' => 'array',
    ];

    /**
     * Tabulador a donde pertenece el repuesto
     *
     * @return BelongsTo
     */
    public function tabulator(): BelongsTo
    {
        return $this->belongsTo(Tabulator::class);
    }

    /**
     * Vista asociada
     *
     * @return BelongsTo
     */
    public function technicalVisit(): BelongsTo
    {
        return $this->belongsTo(TechnicalVisit::class);
    }

    /**
     * Media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('part')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
