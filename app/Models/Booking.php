<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{

    use HasFactory;

    protected $fillable = [
//        'service_id', 'date', 'start_time', 'end_time'
        'service_id',
        'date',
        'time',      // начало слота
        'end_time',  // конец слота
        'client_name',
        'client_phone',
    ];

    /**
     * Каждое бронирование принадлежит одной услуге
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

}
