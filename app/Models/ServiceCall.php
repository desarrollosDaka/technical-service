<?php

namespace App\Models;

use App\Enums\Ticket\Status as TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class ServiceCall extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceCallFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Guarded
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * ServiceCall
     *
     * @var ServiceCall|null
     */
    public static ?ServiceCall $instance = null;

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'app_status' => TicketStatus::class,
        'CLIENT_COORDINATE' => 'array',
    ];

    /**
     * Actual service call
     *
     * @return ServiceCall|null
     */
    public static function current()
    {
        if (self::$instance) {
            return self::$instance;
        }

        $keyBy = 'service_call_for:' . request()->ip();

        return self::$instance = Cache::get($keyBy, null);
    }

    /**
     * Técnico de la llamada de servicio
     *
     * @return void
     */
    public function technical()
    {
        return $this->belongsTo(Technical::class, 'ASSIGNED_TECHNICIAN');
    }

    /**
     * Ticket del service call
     *
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Técnicos de los tickets por los que ha pasado el ticket
     *
     * @return HasManyThrough
     */
    public function technicians(): HasManyThrough
    {
        return $this->hasManyThrough(Technical::class, Ticket::class, 'service_call_id', 'id', 'id');
    }

    /**
     * Técnicos de los tickets por los que ha pasado el ticket
     *
     * @return HasManyThrough
     */
    public function partRequest(): HasManyThrough
    {
        return $this->hasManyThrough(PartRequest::class, Ticket::class, 'service_call_id', 'id', 'id');
    }
}
