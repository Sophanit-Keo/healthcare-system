<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Facility Consents</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <div class="font-semibold text-gray-900">Grant consent</div>
                <form method="POST" action="{{ route('patient.consents.store') }}" class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @csrf
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Facility</label>
                        <select name="facility_id" required class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a facility</option>
                            @foreach ($facilities as $facility)
                                <option value="{{ $facility->id }}" @selected(old('facility_id') == $facility->id)>{{ $facility->name }}</option>
                            @endforeach
                        </select>
                        @error('facility_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Expires at (optional)</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('expires_at')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-3">
                        <button type="submit" class="px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700">Grant consent</button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left p-3">Facility</th>
                            <th class="text-left p-3">Status</th>
                            <th class="text-left p-3">Granted</th>
                            <th class="text-left p-3">Expires</th>
                            <th class="text-right p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($consents as $consent)
                            <tr>
                                <td class="p-3">{{ $consent->facility?->name ?? ('Facility #' . $consent->facility_id) }}</td>
                                <td class="p-3">{{ $consent->status }}</td>
                                <td class="p-3">{{ $consent->granted_at ?? '-' }}</td>
                                <td class="p-3">{{ $consent->expires_at ?? '-' }}</td>
                                <td class="p-3 text-right">
                                    @if ($consent->status === 'granted')
                                        <form method="POST" action="{{ route('patient.consents.destroy', $consent) }}" class="inline" onsubmit="return confirm('Revoke consent?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-700" type="submit">Revoke</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-6 text-center text-gray-500" colspan="5">No consents yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $consents->links() }}</div>
        </div>
    </div>
</x-app-layout>

