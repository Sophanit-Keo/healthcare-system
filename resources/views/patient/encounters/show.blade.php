<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Encounter #{{ $encounter->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Type</div>
                        <div class="text-gray-900">{{ $encounter->encounter_type }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Started</div>
                        <div class="text-gray-900">{{ $encounter->started_at ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Ended</div>
                        <div class="text-gray-900">{{ $encounter->ended_at ?? '-' }}</div>
                    </div>
                </div>

                @if ($encounter->chief_complaint)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Chief complaint</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $encounter->chief_complaint }}</div>
                    </div>
                @endif

                @if ($encounter->diagnosis)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Diagnosis</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $encounter->diagnosis }}</div>
                    </div>
                @endif

                @if ($encounter->treatment_plan)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Treatment plan</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $encounter->treatment_plan }}</div>
                    </div>
                @endif

                @if ($encounter->notes)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Notes</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $encounter->notes }}</div>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="font-semibold text-gray-900">Vital signs</div>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left p-3">Recorded</th>
                                <th class="text-left p-3">Temp</th>
                                <th class="text-left p-3">BP</th>
                                <th class="text-left p-3">HR</th>
                                <th class="text-left p-3">SpO2</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($encounter->vitalSigns as $vs)
                                <tr>
                                    <td class="p-3">{{ $vs->recorded_at ?? $vs->created_at }}</td>
                                    <td class="p-3">{{ $vs->temperature ?? '-' }}</td>
                                    <td class="p-3">
                                        @if ($vs->blood_pressure_systolic && $vs->blood_pressure_diastolic)
                                            {{ $vs->blood_pressure_systolic }}/{{ $vs->blood_pressure_diastolic }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-3">{{ $vs->heart_rate ?? '-' }}</td>
                                    <td class="p-3">{{ $vs->oxygen_saturation ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-gray-500" colspan="5">No vital signs recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="font-semibold text-gray-900">Lab orders</div>
                <div class="mt-4 space-y-3">
                    @forelse ($encounter->labOrders as $order)
                        <div class="border rounded p-4">
                            <div class="flex items-center justify-between">
                                <div class="font-medium text-gray-900">Order #{{ $order->id }}</div>
                                <div class="text-sm text-gray-600">{{ $order->status }}</div>
                            </div>
                            <div class="mt-3">
                                <div class="text-sm text-gray-500">Items</div>
                                <ul class="mt-1 list-disc list-inside text-sm text-gray-800">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->test_name }} ({{ $item->status }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-600">No lab orders linked to this encounter.</div>
                    @endforelse
                </div>
            </div>

            <div>
                <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('patient.encounters.index') }}">Back</a>
            </div>
        </div>
    </div>
</x-app-layout>

