<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $service = Service::find($request->query('service_id'));
        $date = $request->query('date');

        if (!$service || !$date) {
            return response()->json(['slots' => []]);
        }

        $day = Carbon::parse($date);

        // ❌ В воскресенье запись невозможна
        if ($day->isSunday()) {
            return response()->json(['slots' => []]);
        }

        $startWork = Carbon::parse("$date 10:00");
        $endWork = Carbon::parse("$date 20:00");

        $slots = [];
        $duration = $service->duration + 30; // добавляем 30 минут
        $step = 30; // шаг в минутах
        $bookings = Booking::where('date', $date)->get();

        $period = CarbonPeriod::create($startWork, "{$step} minutes", $endWork);

        foreach ($period as $start) {
            $end = $start->copy()->addMinutes($duration);

            // не выходить за рамки рабочего дня
            if ($end->gt($endWork)) {
                break;
            }

            // проверяем пересечения
            $overlaps = $bookings->contains(function ($b) use ($start, $end) {
                $bStart = Carbon::parse("{$b->date} {$b->start_time}");
                $bEnd = Carbon::parse("{$b->date} {$b->end_time}");
                return $start->lt($bEnd) && $end->gt($bStart);
            });

            if (!$overlaps) {
                $slots[] = $start->format('H:i');
            }
        }

        return response()->json(['slots' => $slots]);
    }
}
