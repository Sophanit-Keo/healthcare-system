@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">Appointment #{{ $appointment->id }}</h1>
    <p class="page-hero-subtitle">Details, assigned staff, and notes.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
      <div class="page-container">

        <div class="page-card page-card--narrow">
          <div class="soft-muted">Date / time</div>
          <div style="font-size:1.1rem;font-weight:700;color:#18243a;margin-bottom:10px">
            {{ $appointment->appointment_date?->format('Y-m-d') ?? $appointment->date?->format('Y-m-d') ?? '-' }}
            {{ $appointment->appointment_time ?? $appointment->time ?? '' }}
          </div>

          <div class="form-grid" style="margin-top:6px">
            <div>
              <div class="soft-muted">Facility</div>
              <div style="font-weight:600">{{ $appointment->facility?->name ?? '-' }}</div>
            </div>
            <div>
              <div class="soft-muted">Department</div>
              <div style="font-weight:600">{{ $appointment->departmentRef?->name ?? ($appointment->department ?? '-') }}</div>
            </div>
            <div>
              <div class="soft-muted">Status</div>
              <div style="margin-top:2px">
                @include('patient.partials.status-badge', ['status' => $appointment->status ?? 'scheduled'])
              </div>
            </div>
            <div>
              <div class="soft-muted">Assigned staff</div>
              <div style="font-weight:600">
                @if ($appointment->staff)
                  {{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}
                @else
                  -
                @endif
              </div>
            </div>
          </div>

          @if ($appointment->reason)
            <div style="margin-top:14px">
              <div class="soft-muted">Reason</div>
              <div style="color:#18243a">{{ $appointment->reason }}</div>
            </div>
          @endif

          @if ($appointment->notes)
            <div style="margin-top:14px">
              <div class="soft-muted">Notes</div>
              <div style="color:#18243a;white-space:pre-line">{{ $appointment->notes }}</div>
            </div>
          @endif

          <div style="margin-top:18px;display:flex;flex-wrap:wrap;gap:10px;justify-content:space-between;align-items:center">
            <a href="{{ route('patient.appointments.index') }}" class="link-soft-primary back-link">&larr; Back</a>

            <form method="POST" action="{{ route('patient.appointments.destroy', $appointment) }}" onsubmit="return confirm('Delete this appointment?')">
              @csrf
              @method('DELETE')
              <button class="btn-soft-danger" type="submit">Delete</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
