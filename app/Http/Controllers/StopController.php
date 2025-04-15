<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use Illuminate\Http\Request;

class StopController extends Controller
{
    public function index()
    {
        $stops = Stop::all();
        return view('stops.index', compact('stops'));
    }

    public function create()
    {
        return view('stops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
        ]);

        Stop::create($validated);

        return redirect()->route('stops.index')
            ->with('success', 'Stop created successfully.');
    }

    public function edit(Stop $stop)
    {
        return view('stops.edit', compact('stop'));
    }

    public function update(Request $request, Stop $stop)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
        ]);

        $stop->update($validated);

        return redirect()->route('stops.index')
            ->with('success', 'Stop updated successfully.');
    }

    public function destroy(Stop $stop)
    {
        $stop->delete();
        return redirect()->route('stops.index')
            ->with('success', 'Stop deleted successfully.');
    }
}
