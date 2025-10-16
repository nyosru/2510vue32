<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        $service = Service::find($request->service_id);
        $date = Carbon::parse($request->date);
        $start = Carbon::parse("{$request->date} {$request->time}");
        $end = $start->copy()->addMinutes($service->duration + 30);

        // проверка по времени (10:00–20:00)
        if ($start->hour < 10 || $end->hour >= 20 || $date->isSunday()) {
            return response()->json(['error' => 'Запись вне рабочего времени'], 422);
        }

        // проверка пересечения
        $hasConflict = Booking::where('date', $request->date)
            ->get()
            ->contains(function ($b) use ($start, $end) {
                $bStart = Carbon::parse("{$b->date} {$b->start_time}");
                $bEnd = Carbon::parse("{$b->date} {$b->end_time}");
                return $start->lt($bEnd) && $end->gt($bStart);
            });

        if ($hasConflict) {
            return response()->json(['error' => 'Время уже занято'], 422);
        }

        Booking::create([
            'service_id' => $service->id,
            'date' => $date->format('Y-m-d'),
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
        ]);

        return response()->json(['message' => 'Бронирование успешно создано']);
    }
}
