<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointment #{{ $appointment->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Patient</div>
                        <div class="text-gray-900">{{ $appointment->patient?->user?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="text-gray-900">{{ $appointment->status }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Date / time</div>
                        <div class="text-gray-900">{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Facility</div>
                        <div class="text-gray-900">{{ $appointment->facility?->name ?? '-' }}</div>
                    </div>
                </div>

                @if ($appointment->reason)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Reason</div>
                        <div class="text-gray-900">{{ $appointment->reason }}</div>
                    </div>
                @endif

                @if ($appointment->notes)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Notes</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $appointment->notes }}</div>
                    </div>
                @endif

                <div class="pt-4">
                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('admin.appointments.index') }}">Back</a>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="font-semibold text-gray-900">Encounter</div>
                <div class="mt-2 text-sm text-gray-600">
                    @if ($appointment->encounter)
                        <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('admin.encounters.show', $appointment->encounter) }}">View encounter #{{ $appointment->encounter->id }}</a>
                    @else
                        No encounter linked to this appointment.
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

