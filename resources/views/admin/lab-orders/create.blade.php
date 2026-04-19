<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Lab Order</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('admin.lab-orders.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" required class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select</option>
                            @foreach ($patients as $p)
                                <option value="{{ $p->id }}" @selected(old('patient_id') == $p->id)>{{ $p->user?->name }} ({{ $p->user?->email }})</option>
                            @endforeach
                        </select>
                        @error('patient_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Encounter (optional)</label>
                            <select name="encounter_id" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">--</option>
                                @foreach ($encounters as $e)
                                    <option value="{{ $e->id }}" @selected(old('encounter_id') == $e->id)>#{{ $e->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facility (consent-checked)</label>
                            <select name="facility_id" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">--</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}" @selected(old('facility_id') == $facility->id)>{{ $facility->name }}</option>
                                @endforeach
                            </select>
                            @error('facility_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="border rounded p-4">
                        <div class="font-semibold text-gray-900">Items</div>
                        <p class="mt-1 text-sm text-gray-600">Create 1-3 items. (You can extend this later.)</p>

                        @for ($i = 0; $i < 3; $i++)
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Test name</label>
                                    <input type="text" name="items[{{ $i }}][test_name]" value="{{ old(\"items.$i.test_name\") }}" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="CBC, Glucose, ...">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Test code (optional)</label>
                                    <input type="text" name="items[{{ $i }}][test_code]" value="{{ old(\"items.$i.test_code\") }}" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="CBC">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Specimen (optional)</label>
                                    <input type="text" name="items[{{ $i }}][specimen]" value="{{ old(\"items.$i.specimen\") }}" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Blood, Urine, ...">
                                </div>
                            </div>
                        @endfor

                        @error('items')<div class="text-sm text-red-600 mt-2">{{ $message }}</div>@enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
                        <a class="px-4 py-2 rounded bg-gray-100 text-gray-800 hover:bg-gray-200" href="{{ route('admin.lab-orders.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
