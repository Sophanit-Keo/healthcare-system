<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patients</h2>
            <form method="GET" action="{{ route('admin.patients.index') }}" class="flex items-center gap-2">
                <input name="q" value="{{ request('q') }}" placeholder="Search name, email, username" class="rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
                <button class="px-3 py-2 rounded bg-gray-900 text-white hover:bg-black text-sm" type="submit">Search</button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left p-3">Patient</th>
                            <th class="text-left p-3">Email</th>
                            <th class="text-left p-3">Username</th>
                            <th class="text-left p-3">Phone</th>
                            <th class="text-right p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($patients as $patient)
                            <tr>
                                <td class="p-3">{{ $patient->user?->name ?? ('Patient #' . $patient->id) }}</td>
                                <td class="p-3">{{ $patient->user?->email ?? '-' }}</td>
                                <td class="p-3">{{ $patient->user?->username ?? '-' }}</td>
                                <td class="p-3">{{ $patient->phone ?? '-' }}</td>
                                <td class="p-3 text-right">
                                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('admin.patients.show', $patient) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-6 text-center text-gray-500" colspan="5">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $patients->links() }}</div>
        </div>
    </div>
</x-app-layout>

