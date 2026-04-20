<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointment #{{ $appointment->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 space-y-3">
                <div class="text-sm text-gray-500">Date / time</div>
                <div class="text-lg font-medium text-gray-900">{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <div class="text-sm text-gray-500">Facility</div>
                        <div class="text-gray-900">{{ $appointment->facility?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Department</div>
                        <div class="text-gray-900">{{ $appointment->department?->name ?? '-' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="text-gray-900">{{ $appointment->status }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Assigned staff</div>
                        <div class="text-gray-900">
                            @if ($appointment->staff)
                                {{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                @if ($appointment->reason)
                    <div class="pt-2">
                        <div class="text-sm text-gray-500">Reason</div>
                        <div class="text-gray-900">{{ $appointment->reason }}</div>
                    </div>
                @endif

                @if ($appointment->notes)
                    <div class="pt-2">
                        <div class="text-sm text-gray-500">Notes</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $appointment->notes }}</div>
                    </div>
                @endif

                <div class="pt-4 flex items-center justify-between">
                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('patient.appointments.index') }}">Back</a>

                    <form method="POST" action="{{ route('patient.appointments.destroy', $appointment) }}" onsubmit="return confirm('Delete this appointment?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 rounded bg-red-600 text-white hover:bg-red-700" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

