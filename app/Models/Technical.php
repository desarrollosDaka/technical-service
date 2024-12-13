<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Technical extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\TechnicalFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'Name_user_comercial',
        'Services',
        'User_name',
        'Email',
        'Password',
        'Identification_Comercial',
        'Phone',
        'Address',
        'Tickets',
        'Tickets_rejected',
        'Qualification',
        'Agency',
        'ID_rol',
        'ID_supplier',
        'Availability',
        'GeographicalCoordinates',
        'Create_user',
        'Create_date',
        'Update_user',
        'Update_date',
    ];

    /**
     * Hidden element
     *
     * @var array
     */
    protected $hidden = [
        'Password',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'Password' => 'hashed',
        'Tickets' => 'integer',
        'Tickets_rejected' => 'integer',
        'Qualification' => 'integer',
        'Create_date' => 'datetime',
        'Update_date' => 'datetime',
        'GeographicalCoordinates' => 'array',
    ];

    /**
     * Tickets del técnico
     *
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'technical_id');
    }

    /**
     * Todas las visitas de un técnico
     *
     * @return HasManyThrough
     */
    public function visits(): HasManyThrough
    {
        return $this->hasManyThrough(TechnicalVisit::class, Ticket::class);
    }
}
