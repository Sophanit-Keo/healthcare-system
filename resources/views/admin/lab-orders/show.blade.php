<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lab Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Patient</div>
                        <div class="text-gray-900">{{ $order->patient?->user?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="text-gray-900">{{ $order->status }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Ordered at</div>
                        <div class="text-gray-900">{{ $order->ordered_at ?? $order->created_at }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Encounter</div>
                        <div class="text-gray-900">{{ $order->encounter_id ? ('#' . $order->encounter_id) : '-' }}</div>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="pt-4">
                        <div class="text-sm text-gray-500">Notes</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $order->notes }}</div>
                    </div>
                @endif

                <div class="pt-4">
                    <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('admin.lab-orders.index') }}">Back</a>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="font-semibold text-gray-900">Items</div>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left p-3">Test</th>
                                <th class="text-left p-3">Specimen</th>
                                <th class="text-left p-3">Status</th>
                                <th class="text-left p-3">Result</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="p-3">{{ $item->test_name }}</td>
                                    <td class="p-3">{{ $item->specimen ?? '-' }}</td>
                                    <td class="p-3">{{ $item->status }}</td>
                                    <td class="p-3 whitespace-pre-line">{{ $item->result ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

