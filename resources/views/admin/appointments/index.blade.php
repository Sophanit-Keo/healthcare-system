<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
            <a href="{{ route('admin.appointments.create') }}" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">New</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left p-3">Patient</th>
                            <th class="text-left p-3">Date</th>
                            <th class="text-left p-3">Time</th>
                            <th class="text-left p-3">Facility</th>
                            <th class="text-left p-3">Status</th>
                            <th class="text-right p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($appointments as $a)
                            <tr>
                                <td class="p-3">{{ $a->patient?->user?->name ?? '-' }}</td>
                                <td class="p-3">{{ $a->appointment_date }}</td>
                                <td class="p-3">{{ $a->appointment_time }}</td>
                                <td class="p-3">{{ $a->facility?->name ?? '-' }}</td>
                                <td class="p-3">{{ $a->status }}</td>
                                <td class="p-3 text-right">
                                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('admin.appointments.show', $a) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-6 text-center text-gray-500" colspan="6">No appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $appointments->links() }}</div>
        </div>
    </div>
</x-app-layout>

