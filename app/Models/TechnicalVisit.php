<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalVisit extends Model
{
    /** @use HasFactory<\Database\Factories\TechnicalVisitsFactory> */
    use HasFactory, SoftDeletes;
}