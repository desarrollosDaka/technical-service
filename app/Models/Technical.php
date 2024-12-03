<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    /** @use HasFactory<\Database\Factories\TechnicalFactory> */
    use HasFactory;

    protected $table = 'MASTER_TECHNICIAN';
}
