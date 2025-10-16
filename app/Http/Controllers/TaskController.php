<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
//        $tasks = Task::with('user')->get();
        $tasks = Task::all();
//        dd($tasks->toArray());
        return Inertia::render('Tasks/Index', ['tasks' => $tasks]);
    }
}
