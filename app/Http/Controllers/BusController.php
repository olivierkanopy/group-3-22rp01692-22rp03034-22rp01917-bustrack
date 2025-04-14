<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return view('buses.index', compact('buses'));
    }

    public function create()
    {
        return view('buses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_number' => 'required|unique:buses',
            'plate_number' => 'required|unique:buses',
            'model' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        Bus::create($validated);
        return redirect()->route('buses.index')->with('success', 'Bus added successfully.');
    }

    public function edit(Bus $bus)
    {
        return view('buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'bus_number' => 'required|unique:buses,bus_number,' . $bus->id,
            'plate_number' => 'required|unique:buses,plate_number,' . $bus->id,
            'model' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        $bus->update($validated);
        return redirect()->route('buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('buses.index')->with('success', 'Bus deleted successfully.');
    }
}
