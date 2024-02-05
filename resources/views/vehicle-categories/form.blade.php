<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicle Categories') }}
        </h2>
    </x-slot>

    <div>
        <form action="{{ route('vehicle-categories.store') }}" method="POST">
            @csrf
            <input type="text" name="name" id="name" value="{{ old('name', $vehicleCategory->name) }}">
            <button type="submit">
                Submit
            </button>
    </div>
</x-app-layout>