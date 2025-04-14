@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bus Tracking</div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form id="trackBusForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="busNumber" placeholder="Enter Bus Number">
                                    <button type="submit" class="btn btn-primary">Track Bus</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Bus Number</th>
                                    <th>Plate Number</th>
                                    <th>Model</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($buses as $bus)
                                <tr>
                                    <td>{{ $bus->bus_number }}</td>
                                    <td>{{ $bus->plate_number }}</td>
                                    <td>{{ $bus->model }}</td>
                                    <td>{{ $bus->capacity }}</td>
                                    <td>
                                        <span class="badge bg-{{ $bus->status === 'active' ? 'success' : ($bus->status === 'maintenance' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($bus->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('bus-tracking.show', $bus) }}" class="btn btn-sm btn-info">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('trackBusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const busNumber = document.getElementById('busNumber').value;

        fetch('/bus-tracking/track', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ bus_number: busNumber })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                window.location.href = `/bus-tracking/${data.id}`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while tracking the bus.');
        });
    });
</script>
@endpush
@endsection
