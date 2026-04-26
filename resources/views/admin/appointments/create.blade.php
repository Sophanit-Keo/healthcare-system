@extends('admin.layout')

@section('content')

<div class="page-content active">

    
    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.appointments.index') }}" class="action-btn back-btn">&larr;</a>
                <div>
                    <h1>Book Appointment</h1>
                    <p>Schedule a new patient visit.</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal-like small">

        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf

            @if($errors->any())
                <div style="margin-bottom:16px;padding:12px 14px;background:#fef2f2;color:#dc2626;border-radius:8px">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="form-grid col1">

                
                <div class="form-group">
                    <label class="form-label">Patient<span>*</span></label>
                    <select name="patient_id" class="form-select" required>
                        <option value="">Select patient</option>
                        @foreach(($patients ?? []) as $patient)
                            @php($label = $patient->user?->name ?? ('Patient #' . $patient->id))
                            <option value="{{ $patient->id }}" {{ (string) old('patient_id') === (string) $patient->id ? 'selected' : '' }}>
                                {{ $label }}{{ $patient->user?->email ? ' — ' . $patient->user->email : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Assigned Doctor</label>
                    <select name="health_staff_id" class="form-select">
                        <option value="">Unassigned</option>
                        @foreach(($doctors ?? []) as $doc)
                            <option value="{{ $doc->id }}" {{ (string) old('health_staff_id') === (string) $doc->id ? 'selected' : '' }}>
                                {{ trim(($doc->first_name ?? '') . ' ' . ($doc->last_name ?? '')) ?: ('Doctor #' . $doc->id) }}{{ $doc->email ? ' — ' . $doc->email : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Facility</label>
                    <select name="facility_id" class="form-select">
                        <option value="">Select facility (optional)</option>
                        @foreach(($facilities ?? []) as $facility)
                            <option value="{{ $facility->id }}" {{ (string) old('facility_id') === (string) $facility->id ? 'selected' : '' }}>
                                {{ $facility->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select">
                        <option value="">Select department (optional)</option>
                        @foreach(($departments ?? []) as $dept)
                            <option value="{{ $dept->id }}" {{ (string) old('department_id') === (string) $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Date<span>*</span></label>
                        <input type="date" name="appointment_date" class="form-input" value="{{ old('appointment_date') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Time<span>*</span></label>
                        <input type="time" name="appointment_time" class="form-input" value="{{ old('appointment_time') }}" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="no_show" {{ old('status') === 'no_show' ? 'selected' : '' }}>No Show</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Reason</label>
                    <input type="text" name="reason" class="form-input" placeholder="Reason for visit (optional)" value="{{ old('reason') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
                </div>

            </div>

            
            <div class="modal-footer" style="margin-top:25px;">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Appointment
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
