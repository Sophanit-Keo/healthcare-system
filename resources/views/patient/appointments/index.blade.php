@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <div class="actions-row" style="gap:14px">
      <div>
        <h1 style="color:#fff;margin-bottom:4px">My Appointments</h1>
        <p style="color:rgba(255,255,255,.7)">View upcoming appointments and your history.</p>
      </div>
      <a href="{{ route('patient.appointments.create') }}" class="btn-soft-primary">Request appointment</a>
    </div>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        @if (session('status'))
          <div class="alert-success">{{ session('status') }}</div>
        @endif

        <div class="page-card">
          <div class="soft-table-wrap">
            <table class="soft-table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Facility</th>
                  <th>Department</th>
                  <th>Status</th>
                  <th style="text-align:right">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($appointments as $appointment)
                  <tr>
                    <td>{{ $appointment->appointment_date?->format('Y-m-d') ?? $appointment->date?->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $appointment->appointment_time ?? $appointment->time ?? '-' }}</td>
                    <td>{{ $appointment->facility?->name ?? '-' }}</td>
                    <td>{{ $appointment->departmentRef?->name ?? '-' }}</td>
                    <td>
                      @php($status = (string) ($appointment->status ?? 'scheduled'))
                      <span class="soft-badge {{ $status === 'completed' ? 'green' : ($status === 'cancelled' ? 'red' : ($status === 'no_show' ? 'amber' : '')) }}">
                        {{ str_replace('_', ' ', $status) }}
                      </span>
                    </td>
                    <td style="text-align:right">
                      <a href="{{ route('patient.appointments.show', $appointment) }}" style="color:#1a8a6e;font-weight:600">View</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="soft-muted" style="text-align:center;padding:26px">No appointments yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div style="margin-top:14px">{{ $appointments->links() }}</div>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

