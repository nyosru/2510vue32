<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|integer',
        ]);

        $bookings = Booking::whereDate('date', $request->date)
            ->where('service_id', $request->service_id)
            ->orderBy('time')
            ->get();

        return response()->json($bookings);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['status' => 'deleted']);
    }

    public function availableSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
        ]);

        $service = Service::findOrFail($request->service_id);
        $date = Carbon::parse($request->date);

        // Запрет на воскресенье
        if ($date->isSunday()) {
            return response()->json([]);
        }

        $startHour = 10;
        $endHour = 20;

        $slotDuration = $service->duration + 30; // длительность услуги + 30 мин

        // Генерируем слоты каждые 30 минут
        $slots = [];
        $time = $date->copy()->setHour($startHour)->setMinute(0);
        $endTime = $date->copy()->setHour($endHour)->setMinute(0);

        while ($time->addMinutes(0)->lessThan($endTime)) {
            $slotEnd = $time->copy()->addMinutes($slotDuration);

            // Проверка на выход за пределы 20:00
            if ($slotEnd->hour >= $endHour && $slotEnd->minute > 0) {
                break;
            }

            // Проверка пересечения с существующими бронированиями
            $conflict = Booking::where('service_id', $service->id)
                ->whereDate('date', $date->toDateString())
                ->where(function($q) use ($time, $slotEnd) {

                    $q->whereBetween('time', [$time->format('H:i'), $slotEnd->format('H:i')])
                        ->orWhereBetween('end_time', [$time->format('H:i'), $slotEnd->format('H:i')])
                        ->orWhere(function($q2) use ($time, $slotEnd) {
                            $q2->where('time', '<', $time->format('H:i'))
                                ->where('end_time', '>', $slotEnd->format('H:i'));
                        });
                })
                ->exists();

            if (!$conflict) {
                $slots[] = [
                    'time' => $time->format('H:i'),
                ];
            }

            $time->addMinutes(30);
        }

        return response()->json($slots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'times' => 'required',
            'client_name' => 'required',
            'client_phone' => 'required'
        ]);

        $service = Service::find($request->service_id);
        $date = Carbon::parse($request->date);
//        $start = Carbon::parse("{$request->date} {$request->times}");

        $dateTimeStr = $date->format('Y-m-d') . ' ' . $request->times;
        $start = Carbon::parse($dateTimeStr);

        $end = $start->copy()->addMinutes($service->duration + 29);

        // проверка по времени (10:00–20:00)
        if ($start->hour < 10 || $end->hour >= 20 || $date->isSunday()) {
            return response()->json(['error' => 'Запись вне рабочего времени'], 422);
        }

        // проверка пересечения
        $hasConflict = Booking::where('date', $request->date)
            ->where('service_id', $request->service_id)
            ->whereBetween('time', [$start->hour.':'.$start->minute.':00', $end->hour.':'.$end->minute.':00'])
            ->get();

//        dump($hasConflict->toArray());

        if ( !empty($hasConflict->count() ) ) {

//            $e = '--'.serialize($hasConflict->toArray()).'--';
//            foreach($hasConflict as $conflict) {
//                $e .= "\n".
//                    "\n".
//                    "\n".'---------- '.$conflict->service_id.' --- '.
//                    $conflict->date.' '.$conflict->time.' - '.$conflict->end_time;
//                $e .= "\n".json_encode($conflict->toArray());
//            }

            return response()->json(['error' => 'Время занято ( ошибка №'.__LINE__.' )'], 422);
        }

        Booking::create([
            'service_id' => $service->id,
            'date' => $date->format('Y-m-d'),
            'time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
        ]);

        return response()->json(['message' => 'Бронирование успешно создано']);
    }
}
