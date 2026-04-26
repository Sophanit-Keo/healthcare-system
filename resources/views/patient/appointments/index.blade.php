@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <div class="actions-row actions-row--spaced">
      <div>
        <h1 class="page-hero-title">My Appointments</h1>
        <p class="page-hero-subtitle">View upcoming appointments and your history.</p>
      </div>
      <a href="{{ route('patient.appointments.create') }}" class="btn-soft-primary">Request appointment</a>
    </div>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
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
                  <th class="text-end">Actions</th>
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
                      @include('patient.partials.status-badge', ['status' => $appointment->status ?? 'scheduled'])
                    </td>
                    <td class="text-end">
                      <a href="{{ route('patient.appointments.show', $appointment) }}" class="link-soft-primary">View</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="soft-muted soft-empty">No appointments yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">{{ $appointments->links('pagination::bootstrap-5') }}</div>
        </div>

        <div class="mt-2">
          <a href="{{ route('dashboard') }}" class="link-soft-primary back-link">&larr; Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
