<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Patient Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Appointments</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $appointmentsCount }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Encounters</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $encountersCount }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Lab Orders</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $labOrdersCount }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Consents</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $consentsCount }}</div>
                </div>
            </div>

            <div class="mt-6 bg-white p-6 rounded-lg shadow">
                <div class="flex flex-wrap gap-3">
                    <a class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700" href="{{ route('patient.appointments.index') }}">My Appointments</a>
                    <a class="px-4 py-2 rounded bg-gray-900 text-white hover:bg-black" href="{{ route('patient.encounters.index') }}">My Encounters</a>
                    <a class="px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700" href="{{ route('patient.consents.index') }}">Manage Consents</a>
                    <a class="px-4 py-2 rounded bg-sky-600 text-white hover:bg-sky-700" href="{{ route('patient.lab-orders.index') }}">My Lab Orders</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

