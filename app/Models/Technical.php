<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Technical extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\TechnicalFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'MASTER_TECHNICIAN';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'ID_user';

    /**
     * Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

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
    ];

    /**
     * Tickets del técnico
     *
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
