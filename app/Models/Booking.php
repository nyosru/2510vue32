<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
//        'service_id', 'date', 'start_time', 'end_time'
        'service_id',
        'date',
        'time',      // начало слота
        'end_time',  // конец слота
        'client_name',
        'client_phone',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
