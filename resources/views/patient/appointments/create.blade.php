@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">Request Appointment</h1>
    <p style="color:rgba(255,255,255,.7)">Choose a date/time and optionally a facility/department.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card" style="max-width:860px;margin-left:auto;margin-right:auto">
          <div id="api-errors" class="alert-danger" style="display:none;white-space:pre-line"></div>

          <form id="appointment-form" method="POST" action="{{ route('patient.appointments.store') }}" data-api-submit="1">
            @csrf

            <div class="form-grid" style="margin-bottom:14px">
              <div>
                <label class="form-label">Date</label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required class="form-input">
                @error('appointment_date')<div class="form-error">{{ $message }}</div>@enderror
              </div>
              <div>
                <label class="form-label">Time</label>
                <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required class="form-input">
                @error('appointment_time')<div class="form-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="form-grid" style="margin-bottom:14px">
              <div>
                <label class="form-label">Facility (optional)</label>
                <select name="facility_id" class="form-select">
                  <option value="">--</option>
                  @foreach ($facilities as $facility)
                    <option value="{{ $facility->id }}" @selected(old('facility_id') == $facility->id)>{{ $facility->name }}</option>
                  @endforeach
                </select>
                @error('facility_id')<div class="form-error">{{ $message }}</div>@enderror
              </div>
              <div>
                <label class="form-label">Department (optional)</label>
                <select name="department_id" class="form-select">
                  <option value="">--</option>
                  @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                  @endforeach
                </select>
                @error('department_id')<div class="form-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="form-grid-1" style="margin-bottom:14px">
              <div>
                <label class="form-label">Reason (optional)</label>
                <input type="text" name="reason" value="{{ old('reason') }}" class="form-input">
                @error('reason')<div class="form-error">{{ $message }}</div>@enderror
              </div>
              <div>
                <label class="form-label">Notes (optional)</label>
                <textarea name="notes" class="form-textarea">{{ old('notes') }}</textarea>
                @error('notes')<div class="form-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:flex-end;margin-top:6px">
              <a class="btn-soft-ghost" href="{{ route('patient.appointments.index') }}">Cancel</a>
              <button type="submit" class="btn-soft-primary">Submit</button>
            </div>
          </form>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('patient.appointments.index') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Appointments</a>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  (function () {
    const form = document.getElementById('appointment-form');
    const errorsEl = document.getElementById('api-errors');
    if (!form || !window.api) return;

    form.addEventListener('submit', async function (e) {
      if (!form.dataset.apiSubmit) return;
      e.preventDefault();

      errorsEl.style.display = 'none';
      errorsEl.textContent = '';

      const fd = new FormData(form);
      const payload = Object.fromEntries(fd.entries());

      try {
        await window.api.post('/appointments', payload);
        window.location.href = @json(route('patient.appointments.index'));
      } catch (err) {
        const resp = err?.response;
        if (resp?.status === 422 && resp?.data?.errors) {
          const lines = [];
          for (const key in resp.data.errors) {
            for (const msg of resp.data.errors[key]) lines.push(msg);
          }
          errorsEl.textContent = lines.join('\\n');
          errorsEl.style.display = 'block';
          return;
        }
        errorsEl.textContent = 'Failed to request appointment via API. Please try again.';
        errorsEl.style.display = 'block';
      }
    });
  })();
</script>
@endsection

