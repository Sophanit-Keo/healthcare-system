<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Encounters</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left p-3">Type</th>
                            <th class="text-left p-3">Started</th>
                            <th class="text-left p-3">Ended</th>
                            <th class="text-left p-3">Diagnosis</th>
                            <th class="text-right p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($encounters as $encounter)
                            <tr>
                                <td class="p-3">{{ $encounter->encounter_type }}</td>
                                <td class="p-3">{{ $encounter->started_at }}</td>
                                <td class="p-3">{{ $encounter->ended_at ?? '-' }}</td>
                                <td class="p-3">{{ \Illuminate\Support\Str::limit((string) $encounter->diagnosis, 60) }}</td>
                                <td class="p-3 text-right">
                                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('patient.encounters.show', $encounter) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-6 text-center text-gray-500" colspan="5">No encounters yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $encounters->links() }}</div>
        </div>
    </div>
</x-app-layout>

