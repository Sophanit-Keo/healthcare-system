<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-900 font-medium">Welcome, {{ Auth::user()->name }}</div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700" href="{{ route('admin.patients.index') }}">Patients</a>
                    <a class="px-4 py-2 rounded bg-gray-900 text-white hover:bg-black" href="{{ route('admin.appointments.index') }}">Appointments</a>
                    <a class="px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700" href="{{ route('admin.encounters.index') }}">Encounters</a>
                    <a class="px-4 py-2 rounded bg-sky-600 text-white hover:bg-sky-700" href="{{ route('admin.lab-orders.index') }}">Lab Orders</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

