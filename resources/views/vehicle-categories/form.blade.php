<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicle Categories') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ $category->id ? route('vehicle-categories.update', $category->id) : route('vehicle-categories.store') }}" method="post" class="space-y-6">
                        @csrf
                        @if ($category->id)
                            @method('PUT')
                        @endif

                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="vehicle_category_name" :value="old('vehicle_category_name', $category->vehicle_category_name)" required autofocus />
                        </div>

                        <div>
                            <x-label for="brand" :value="__('Brand')" />
                            <x-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand', $category->brand)" required />
                        </div>

                        <div>
                            <x-label for="model" :value="__('Model')" />
                            <x-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model', $category->model)" required />
                        </div>

                        <div>
                            <x-label for="year" :value="__('Year')" />
                            <x-input id="year" class="block mt-1 w-full" type="text" name="year" :value="old('year', $category->year)" required />
                        </div>

                        <div>
                            <x-label for="color" :value="__('Color')" />
                            <x-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color', $category->color)" required />
                        </div>

                        <div>
                            <x-label for="plate_number" :value="__('Plate Number')" />
                            <x-input id="plate_number" class="block mt-1 w-full" type="text" name="plate_number" :value="old('plate_number', $category->plate_number)" required />
                        </div>

                        <div>
                            <x-label for="price" :value="__('Price')" />
                            <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price', $category->price)" required />
                        </div>

                        <!-- Add more form fields as needed -->

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
