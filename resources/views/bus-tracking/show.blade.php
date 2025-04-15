@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Bus Details: {{ $bus->bus_number }}
                    <a href="{{ route('bus-tracking.index') }}" class="btn btn-sm btn-secondary float-end">Back to List</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Bus Information</h5>
                            <table class="table">
                                <tr>
                                    <th>Plate Number:</th>
                                    <td>{{ $bus->plate_number }}</td>
                                </tr>
                                <tr>
                                    <th>Model:</th>
                                    <td>{{ $bus->model }}</td>
                                </tr>
                                <tr>
                                    <th>Capacity:</th>
                                    <td>{{ $bus->capacity }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $bus->status === 'active' ? 'success' : ($bus->status === 'maintenance' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($bus->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Current Schedule</h5>
                            @if($bus->schedules->isNotEmpty())
                                @php
                                    $currentSchedule = $bus->schedules->first();
                                @endphp
                                <table class="table">
                                    <tr>
                                        <th>Route:</th>
                                        <td>{{ $currentSchedule->route->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>From:</th>
                                        <td>{{ $currentSchedule->route->start_point }}</td>
                                    </tr>
                                    <tr>
                                        <th>To:</th>
                                        <td>{{ $currentSchedule->route->end_point }}</td>
                                    </tr>
                                    <tr>
                                        <th>Departure Time:</th>
                                        <td>{{ $currentSchedule->departure_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Arrival Time:</th>
                                        <td>{{ $currentSchedule->arrival_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Schedule Date:</th>
                                        <td>{{ $currentSchedule->schedule_date }}</td>
                                    </tr>
                                </table>
                            @else
                                <p>No active schedule found for this bus.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Location Map</h5>
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function initMap() {
        // Default coordinates (you should replace these with actual bus coordinates)
        const defaultLocation = { lat: 0, lng: 0 };

        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: defaultLocation
        });

        const marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            title: 'Bus Location'
        });

        // You can update the marker position with real-time data
        // This is just a placeholder for the actual implementation
        function updateBusLocation() {
            // Fetch real-time location data from your API
            // Update marker position
        }

        // Update location every 30 seconds
        setInterval(updateBusLocation, 30000);
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>
@endpush
@endsection
