<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualifySupport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'qualification',
        'comment',
        'ticket_id',
    ];
}
