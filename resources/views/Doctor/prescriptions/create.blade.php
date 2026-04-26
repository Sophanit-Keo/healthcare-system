@extends('layout.main')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a2a5e 100%);padding:50px 0 34px">
  <div class="container">
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
      <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-sm" style="background:#f3f4f6;color:#6b7280;border:none;border-radius:10px">Back</a>
      <div>
        <h1 style="color:#fff;margin-bottom:4px">New Prescription</h1>
        <p style="color:rgba(255,255,255,.7)">Fill in the prescription details.</p>
      </div>
    </div>
  </div>
</div>

<div class="page-section">
  <div class="container" style="max-width:880px">
    @if ($errors->any())
      <div style="margin-bottom:18px;padding:12px 16px;background:#fef2f2;color:#dc2626;border-radius:10px">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <div style="background:#fff;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);padding:24px">
      <form method="POST" action="{{ route('doctor.prescriptions.store') }}">
        @csrf

        <div class="row">
          <div class="col-md-12 mb-3">
            <label style="font-weight:600">Patient <span style="color:#dc2626">*</span></label>
            <select name="user_id" class="form-control" required>
              <option value="">-- Select patient --</option>
              @foreach(($patients ?? []) as $p)
                <option value="{{ $p->id }}" {{ (string)old('user_id') === (string)$p->id ? 'selected' : '' }}>
                  {{ $p->name }} ({{ $p->email }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label style="font-weight:600">Medication <span style="color:#dc2626">*</span></label>
            <input type="text" name="medication" class="form-control" value="{{ old('medication') }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label style="font-weight:600">Dosage</label>
            <input type="text" name="dosage" class="form-control" value="{{ old('dosage') }}" placeholder="e.g. 500mg">
          </div>

          <div class="col-md-6 mb-3">
            <label style="font-weight:600">Frequency</label>
            <input type="text" name="frequency" class="form-control" value="{{ old('frequency') }}" placeholder="e.g. Twice daily">
          </div>

          <div class="col-md-3 mb-3">
            <label style="font-weight:600">Start Date <span style="color:#dc2626">*</span></label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->toDateString()) }}" required>
          </div>

          <div class="col-md-3 mb-3">
            <label style="font-weight:600">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
          </div>

          <div class="col-md-6 mb-3">
            <label style="font-weight:600">Status</label>
            <select name="status" class="form-control">
              <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
              <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
          </div>

          <div class="col-md-12 mb-3">
            <label style="font-weight:600">Notes</label>
            <textarea name="notes" rows="4" class="form-control" placeholder="Instructions / notes...">{{ old('notes') }}</textarea>
          </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:6px">
          <a href="{{ route('doctor.prescriptions.index') }}" class="btn" style="background:#f3f4f6;color:#6b7280;border:none;border-radius:10px">Cancel</a>
          <button type="submit" class="btn btn-primary" style="border-radius:10px">Save Prescription</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

