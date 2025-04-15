@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Buses
                    <a href="{{ route('buses.create') }}" class="btn btn-primary btn-sm float-end">Add New Bus</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

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
                                        <a href="{{ route('buses.edit', $bus) }}" class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('buses.destroy', $bus) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this bus?')">Delete</button>
                                        </form>
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
@endsection
