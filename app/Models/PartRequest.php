<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PartRequest\Status as PartRequestStatus;

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
}
