<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['route', 'bus'])->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $routes = Route::all();
        $buses = Bus::where('status', 'active')->get();
        return view('schedules.create', compact('routes', 'buses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_time' => 'required',
            'arrival_time' => 'required|after:departure_time',
            'schedule_date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['status'] = 'scheduled';

        Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $buses = Bus::where('status', 'active')->get();
        $routes = Route::all();
        return view('schedules.edit', compact('schedule', 'buses', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_time' => 'required',
            'arrival_time' => 'required|after:departure_time',
            'schedule_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    public function updateStatus(Schedule $schedule, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $schedule->update($validated);

        return response()->json(['message' => 'Status updated successfully']);
    }
}
