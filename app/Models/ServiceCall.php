<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCall extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceCallFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [];
}
