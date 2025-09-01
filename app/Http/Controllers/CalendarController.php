<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Appointment::all();
        return Inertia::render('Calendar/Index',[
            'events' => $events
        ]);
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $data = [
            'title' => $request->title,
            'user_id' => 1,
            'details' => $request->appointment,
            'start' => $request->start,
            'end' => $request->end
        ];
        Appointment::create($data);
    }
}
