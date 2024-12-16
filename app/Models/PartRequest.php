<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PartRequest\Status as PartRequestStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status',
        'tabulator_id',
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
}
