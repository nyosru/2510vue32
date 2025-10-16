<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;

class ServiceController extends Controller
{


    public function index()
    {
//        $tasks = Task::with('user')->get();
        $items = Service::all();
//        dd($tasks->toArray());
        return Inertia::render('Services/Index', [
            'items' => $items,
            'appName' => 'Услуги',
        ]);
    }
}
