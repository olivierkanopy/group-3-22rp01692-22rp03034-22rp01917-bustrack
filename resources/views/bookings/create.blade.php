@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Book a Schedule</h1>

            <form action="{{ route('bookings.store') }}" method="POST">
                @csrf

                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">Schedule Details</h2>
                    <div class="bg-gray-50 p-4 rounded">
                        <p><strong>Route:</strong> {{ $schedule->route->name }}</p>
                        <p><strong>Time:</strong> {{ date('h:i A', strtotime($schedule->departure_time)) }} - {{ date('h:i A', strtotime($schedule->arrival_time)) }}</p>
                        <p><strong>Days:</strong> 
                            @php
                                $days = explode(',', $schedule->days_of_week);
                                $dayNames = ['', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                $displayDays = array_map(function($day) use ($dayNames) {
                                    return $dayNames[$day];
                                }, $days);
                            @endphp
                            {{ implode(', ', $displayDays) }}
                        </p>
                        <p><strong>Bus:</strong> {{ $schedule->bus->number }}</p>
                        <p><strong>Price:</strong> ₱{{ number_format($schedule->route->base_fare, 2) }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="seat_number" class="block text-gray-700 text-sm font-bold mb-2">Seat Number</label>
                    <input type="number" name="seat_number" id="seat_number" min="1" max="{{ $schedule->bus->capacity }}" 
                        value="{{ old('seat_number') }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <p class="text-sm text-gray-500 mt-1">Available seats: 1 to {{ $schedule->bus->capacity }}</p>
                    @error('seat_number')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Create Booking
                    </button>
                    <a href="{{ route('schedules.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
