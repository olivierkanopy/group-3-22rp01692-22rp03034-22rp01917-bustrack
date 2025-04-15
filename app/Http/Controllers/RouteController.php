<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        return view('routes.index', compact('routes'));
    }

    public function create()
    {
        return view('routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'description' => 'nullable|string',
            'distance' => 'required|numeric|min:0',
            'estimated_time' => 'required|numeric|min:0',
        ]);

        Route::create($validated);

        return redirect()->route('routes.index')
            ->with('success', 'Route created successfully.');
    }

    public function edit(Route $route)
    {
        $stops = Stop::all();
        return view('routes.edit', compact('route', 'stops'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'description' => 'nullable|string',
            'distance' => 'required|numeric|min:0',
            'estimated_time' => 'required|numeric|min:0'
        ]);

        $route->update($validated);

        return redirect()->route('routes.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('routes.index')
            ->with('success', 'Route deleted successfully.');
    }
}
