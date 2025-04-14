@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Bus Stops</h1>
        <a href="{{ route('stops.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add New Stop
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($stops as $stop)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-2">{{ $stop->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $stop->location }}</p>
                <div class="text-sm text-gray-500 mb-4">
                    <p>Latitude: {{ $stop->latitude }}</p>
                    <p>Longitude: {{ $stop->longitude }}</p>
                </div>
                @if($stop->description)
                    <p class="text-gray-600 mb-4">{{ $stop->description }}</p>
                @endif
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('stops.edit', $stop) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form action="{{ route('stops.destroy', $stop) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this stop?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        <div id="map" class="w-full h-96 rounded-lg shadow-md"></div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap" async defer></script>
<script>
function initMap() {
    const stops = @json($stops);
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: { lat: stops[0].latitude, lng: stops[0].longitude }
    });

    stops.forEach(stop => {
        new google.maps.Marker({
            position: { lat: parseFloat(stop.latitude), lng: parseFloat(stop.longitude) },
            map: map,
            title: stop.name
        });
    });
}
</script>
@endpush
@endsection
