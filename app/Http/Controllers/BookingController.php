<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()->with(['schedule'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(Schedule $schedule)
    {
        return view('bookings.create', compact('schedule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_number' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $schedule = Schedule::find($request->schedule_id);
                    if ($schedule && $value > $schedule->bus->capacity) {
                        $fail('The seat number exceeds the bus capacity.');
                    }
                    
                    $seatTaken = Booking::where('schedule_id', $request->schedule_id)
                        ->where('seat_number', $value)
                        ->where('status', '!=', 'cancelled')
                        ->exists();
                    
                    if ($seatTaken) {
                        $fail('This seat is already taken.');
                    }
                },
            ],
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'schedule_id' => $validated['schedule_id'],
            'seat_number' => $validated['seat_number'],
            'total_price' => $schedule->price,
            'status' => 'pending',
            'payment_status' => 'pending',
            'booking_reference' => 'BK-' . Str::upper(Str::random(8)),
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['schedule.bus', 'schedule.route']);
        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->status === 'confirmed' && $booking->schedule->schedule_date < now()) {
            return back()->with('error', 'Cannot cancel a past booking.');
        }

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'refunded'
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    public function confirmPayment(Booking $booking)
    {
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Payment confirmed successfully.');
    }
}
