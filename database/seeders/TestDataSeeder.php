<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
       
        $bus = Bus::create([
            'number' => 'BUS-001',
            'model' => 'Test Bus',
            'capacity' => 40,
            'status' => 'active',
            'notes' => 'Test bus'
        ]);

        // Create test route
        $route = Route::create([
            'name' => 'Test Route',
            'origin' => 'City A',
            'destination' => 'City B',
            'base_fare' => 100,
            'distance' => 50,
            'description' => 'Test route',
            'is_active' => true
        ]);

        // Create test schedule
        Schedule::create([
            'route_id' => $route->id,
            'bus_id' => $bus->id,
            'departure_time' => '08:00',
            'arrival_time' => '10:00',
            'days_of_week' => '1,2,3,4,5',
            'is_active' => true
        ]);
    }
}
