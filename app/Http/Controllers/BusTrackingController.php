<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Route;
use Illuminate\Http\Request;

class BusTrackingController extends Controller
{
    public function index()
    {
        $buses = Bus::with(['schedules.route'])->get();
        return view('bus-tracking.index', compact('buses'));
    }

    public function show(Bus $bus)
    {
        $bus->load(['schedules.route']);
        return view('bus-tracking.show', compact('bus'));
    }

    public function trackBus(Request $request)
    {
        $busNumber = $request->input('bus_number');
        $bus = Bus::where('bus_number', $busNumber)
            ->with(['schedules.route'])
            ->first();

        if (!$bus) {
            return response()->json(['error' => 'Bus not found'], 404);
        }

        return response()->json($bus);
    }
}
