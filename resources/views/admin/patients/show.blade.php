@extends('admin.layout')
@section('title', 'Patient Details')
@section('content')
<div class="page-content active">
    <div class="page-header"><div class="page-header-left"><h1>{{ $patient->user?->name ?? 'Patient #'.$patient->id }}</h1><p>{{ $patient->user?->email }} · {{ $patient->phone }}</p></div><a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-primary">Edit Patient</a></div>
    <div class="stats-grid" style="grid-template-columns:repeat(4,1fr)">
        <div class="stat-card c-green"><div class="stat-value">{{ $patient->appointments->count() }}</div><div class="stat-label">Recent Appointments</div></div>
        <div class="stat-card c-blue"><div class="stat-value">{{ $patient->encounters->count() }}</div><div class="stat-label">Recent Encounters</div></div>
        <div class="stat-card c-amber"><div class="stat-value">{{ $patient->labOrders->count() }}</div><div class="stat-label">Lab Orders</div></div>
        <div class="stat-card c-purple"><div class="stat-value">{{ $patient->facilityConsents->where('status','granted')->count() }}</div><div class="stat-label">Granted Consents</div></div>
    </div>
    <div class="table-card"><div class="table-header"><div><div class="table-title">Patient Information</div></div></div><div style="padding:20px;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px"><div><strong>Date of birth</strong><br>{{ $patient->date_of_birth?->format('d M Y') ?? '—' }}</div><div><strong>Gender</strong><br>{{ ucfirst($patient->gender ?? '—') }}</div><div><strong>Blood type</strong><br>{{ $patient->blood_type ?? '—' }}</div><div><strong>Address</strong><br>{{ $patient->address ?? '—' }}</div><div><strong>Emergency contact</strong><br>{{ $patient->emergency_contact_name ?? '—' }} {{ $patient->emergency_contact_phone }}</div><div><strong>Account status</strong><br>{{ ucfirst($patient->user?->status ?? 'active') }}</div></div></div>
    <div class="table-card" style="margin-top:20px"><div class="table-header"><div class="table-title">Recent Appointments</div></div><table class="data-table"><thead><tr><th>Date</th><th>Status</th><th>Reason</th><th></th></tr></thead><tbody>@forelse($patient->appointments as $appointment)<tr><td>{{ $appointment->appointment_date?->format('d M Y') }} {{ $appointment->appointment_time }}</td><td>{{ ucfirst($appointment->status) }}</td><td>{{ $appointment->reason ?? '—' }}</td><td><a href="{{ route('admin.appointments.show', $appointment) }}">View</a></td></tr>@empty<tr><td colspan="4">No appointments.</td></tr>@endforelse</tbody></table></div>
</div>
@endsection