<?php

namespace App\Models;

use App\Enums\ServiceCall\Status as ServiceCallStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class ServiceCall extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceCallFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static ?ServiceCall $instance = null;

    protected $casts = [
        'app_status' => ServiceCallStatus::class,
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
     * @return HasOne
     */
    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
