@extends('admin.layout')
@section('title', 'Edit Appointment')
@section('content')
<div class="page-content active">
    <div class="page-header"><div class="page-header-left"><h1>Edit Appointment #{{ $appointment->id }}</h1><p>Update scheduling and visit details.</p></div></div>
    <div class="modal-like small">
        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
            @csrf @method('PUT')
            @if($errors->any())<div style="margin-bottom:16px;padding:12px;background:#fef2f2;color:#dc2626;border-radius:8px">{{ $errors->first() }}</div>@endif
            <div class="form-grid col1">
                <div class="form-group"><label class="form-label">Patient<span>*</span></label><select name="patient_id" class="form-select" required><option value="">Select patient</option>@foreach($patients as $patient)<option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id) == $patient->id)>{{ $patient->user?->name ?? 'Patient #'.$patient->id }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label">Assigned Doctor</label><select name="health_staff_id" class="form-select"><option value="">Unassigned</option>@foreach($doctors as $doctor)<option value="{{ $doctor->id }}" @selected(old('health_staff_id', $appointment->health_staff_id) == $doctor->id)>{{ trim($doctor->first_name.' '.$doctor->last_name) }}</option>@endforeach</select></div>
                <div class="form-row-2">
                    <div class="form-group"><label class="form-label">Facility</label><select name="facility_id" class="form-select"><option value="">None</option>@foreach($facilities as $facility)<option value="{{ $facility->id }}" @selected(old('facility_id', $appointment->facility_id) == $facility->id)>{{ $facility->name }}</option>@endforeach</select></div>
                    <div class="form-group"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">General</option>@foreach($departments as $department)<option value="{{ $department->id }}" @selected(old('department_id', $appointment->department_id) == $department->id)>{{ $department->name }}</option>@endforeach</select></div>
                </div>
                <div class="form-row-2">
                    <div class="form-group"><label class="form-label">Date<span>*</span></label><input type="date" name="appointment_date" class="form-input" value="{{ old('appointment_date', $appointment->appointment_date?->format('Y-m-d')) }}" required></div>
                    <div class="form-group"><label class="form-label">Time<span>*</span></label><input type="time" name="appointment_time" class="form-input" value="{{ old('appointment_time', substr((string) $appointment->appointment_time, 0, 5)) }}" required></div>
                </div>
                <div class="form-group"><label class="form-label">Status<span>*</span></label><select name="status" class="form-select" required>@foreach(['scheduled','completed','cancelled','no_show'] as $status)<option value="{{ $status }}" @selected(old('status', $appointment->status) === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label">Reason</label><input name="reason" class="form-input" value="{{ old('reason', $appointment->reason) }}"></div>
                <div class="form-group"><label class="form-label">Notes</label><textarea name="notes" class="form-textarea">{{ old('notes', $appointment->notes) }}</textarea></div>
            </div>
            <div class="modal-footer" style="margin-top:25px"><a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-outline">Cancel</a><button class="btn btn-primary">Save Changes</button></div>
        </form>
    </div>
</div>
@endsection