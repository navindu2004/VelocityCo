<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- {{ __('Dashboard') }} -->
            THIS IS THE USER DASHBOARD ONLY.
        </h2>
    </x-slot>
    @auth
    @if(Auth::user()->type !== 'admin')
        <!-- Links for non-admin users -->
    @endif
@endauth

    <div class="py-12">
        This is the new page
    </div>
</x-app-layout>