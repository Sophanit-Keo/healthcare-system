<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Patient: {{ $patient->user?->name ?? ('#' . $patient->id) }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Name</div>
                        <div class="text-gray-900">{{ $patient->user?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="text-gray-900">{{ $patient->user?->email ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Username</div>
                        <div class="text-gray-900">{{ $patient->user?->username ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Phone</div>
                        <div class="text-gray-900">{{ $patient->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">DOB</div>
                        <div class="text-gray-900">{{ $patient->date_of_birth ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Gender</div>
                        <div class="text-gray-900">{{ $patient->gender ?? '-' }}</div>
                    </div>
                </div>

                @if ($patient->address)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Address</div>
                        <div class="text-gray-900">{{ $patient->address }}</div>
                    </div>
                @endif

                <div class="pt-4">
                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('admin.patients.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

