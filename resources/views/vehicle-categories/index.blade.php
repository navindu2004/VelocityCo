<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicles') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-1">
        <div class="px-4 sm:px-6 lg:px-8 bg-white pt-4">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Vehicles</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the vehicles in your account including their details like number, owner, and status.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('vehicle.create') }}"
                       class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-sm font-semibold leading-4 text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Create Vehicle
                    </a>
                </div>
            </div>

            <!-- Vehicle Table -->
            <div class="mt-8 flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Owner</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($vehicleCategories as $vehicleCategory)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $vehicle->id }}</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-900">{{ $vehicle->number }}</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-900">{{ $vehicle->owner_name }}</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-900">{{ $vehicle->status }}</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-900">
                                            <a href="{{ route('vehicle.show', $vehicle->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a> /
                                            <a href="{{ route('vehicle.edit', $vehicle->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Vehicle Table -->

            {{ $vehicleCategories->links() }}
        </div>
    </div>
</x-app-layout>