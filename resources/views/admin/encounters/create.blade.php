<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Encounter</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('admin.encounters.store') }}" class="space-y-4">
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
                            <label class="block text-sm font-medium text-gray-700">Encounter type</label>
                            <select name="encounter_type" required class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach (['outpatient','inpatient','emergency','follow_up'] as $t)
                                    <option value="{{ $t }}" @selected(old('encounter_type') == $t)>{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('encounter_type')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Appointment (optional)</label>
                            <select name="appointment_id" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">--</option>
                                @foreach ($appointments as $a)
                                    <option value="{{ $a->id }}" @selected(old('appointment_id') == $a->id)>#{{ $a->id }} ({{ $a->appointment_date }} {{ $a->appointment_time }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facility (optional)</label>
                            <select name="facility_id" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">--</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}" @selected(old('facility_id') == $facility->id)>{{ $facility->name }}</option>
                                @endforeach
                            </select>
                            @error('facility_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department (optional)</label>
                            <select name="department_id" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">--</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Started at (optional)</label>
                            <input type="datetime-local" name="started_at" value="{{ old('started_at') }}" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ended at (optional)</label>
                            <input type="datetime-local" name="ended_at" value="{{ old('ended_at') }}" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Chief complaint (optional)</label>
                        <textarea name="chief_complaint" rows="3" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('chief_complaint') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Diagnosis (optional)</label>
                        <textarea name="diagnosis" rows="3" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('diagnosis') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Treatment plan (optional)</label>
                        <textarea name="treatment_plan" rows="3" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('treatment_plan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
                        <a class="px-4 py-2 rounded bg-gray-100 text-gray-800 hover:bg-gray-200" href="{{ route('admin.encounters.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

