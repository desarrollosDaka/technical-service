<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCall extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceCallFactory> */
    use HasFactory;

    protected $table = 'service_calls';

    protected $primaryKey = 'callID';

    protected $fillable = [];
}
