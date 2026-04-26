@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">Appointment #{{ $appointment->id }}</h1>
    <p style="color:rgba(255,255,255,.7)">Details, assigned staff, and notes.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card" style="max-width:900px;margin-left:auto;margin-right:auto">
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
              @php($status = (string) ($appointment->status ?? 'scheduled'))
              <div style="margin-top:2px">
                <span class="soft-badge {{ $status === 'completed' ? 'green' : ($status === 'cancelled' ? 'red' : ($status === 'no_show' ? 'amber' : '')) }}">{{ str_replace('_', ' ', $status) }}</span>
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
            <a href="{{ route('patient.appointments.index') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back</a>

            <form method="POST" action="{{ route('patient.appointments.destroy', $appointment) }}" onsubmit="return confirm('Delete this appointment?')">
              @csrf
              @method('DELETE')
              <button class="btn-soft-ghost" style="background:#fef2f2;color:#b91c1c" type="submit">Delete</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

