@extends('admin.layout')
@section('title', 'Appointments')

@section('content')

  <div class="page-content active" id="page-appointments">
    <div class="page-header">
      <div class="page-header-left">
        <h1>Manage Appointments</h1>
        <p>Schedule, confirm and track all patient appointments.</p>
      </div>
      <div style="display:flex;gap:8px">
        <button class="btn btn-outline">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Calendar View
        </button>
             <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
                  <div class="nav-icon">
                      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                      </svg>
                  </div>
                  Add Appointment
              </a>
      </div>
    </div>

    <div class="stats-grid" style="grid-template-columns:repeat(4,1fr)">
      <div class="stat-card c-green"><div class="stat-card-top"><div class="stat-icon green"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div><div><div class="stat-value">18</div><div class="stat-label">Confirmed Today</div></div></div>
      <div class="stat-card c-blue"><div class="stat-card-top"><div class="stat-icon blue"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div><div><div class="stat-value">4</div><div class="stat-label">Pending Approval</div></div></div>
      <div class="stat-card c-amber"><div class="stat-card-top"><div class="stat-icon amber"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div></div><div><div class="stat-value">1,340</div><div class="stat-label">This Month</div></div></div>
      <div class="stat-card c-purple"><div class="stat-card-top"><div class="stat-icon purple"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></div></div><div><div class="stat-value">2</div><div class="stat-label">Cancelled Today</div></div></div>
    </div>

    <div class="table-card">
      <div class="search-bar">
        <form method="GET" action="{{ route('admin.appointments.index') }}" style="display:contents">
          <div class="search-input-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search appointments…">
          </div>
          @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
          @if(request('date'))<input type="hidden" name="date" value="{{ request('date') }}">@endif
        </form>
        <div class="status-filter">
          <a href="{{ route('admin.appointments.index', array_merge(request()->except('status','page'), [])) }}"
             class="status-tab {{ !request('status') ? 'active' : '' }}">All</a>
          <a href="{{ route('admin.appointments.index', array_merge(request()->except('status','page'), ['status'=>'confirmed'])) }}"
             class="status-tab {{ request('status')==='confirmed' ? 'active' : '' }}">Confirmed</a>
          <a href="{{ route('admin.appointments.index', array_merge(request()->except('status','page'), ['status'=>'pending'])) }}"
             class="status-tab {{ request('status')==='pending' ? 'active' : '' }}">Pending</a>
          <a href="{{ route('admin.appointments.index', array_merge(request()->except('status','page'), ['status'=>'cancelled'])) }}"
             class="status-tab {{ request('status')==='cancelled' ? 'active' : '' }}">Cancelled</a>
        </div>
        <form method="GET" action="{{ route('admin.appointments.index') }}" style="margin-left:auto">
          @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
          @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
          <input type="date" name="date" class="filter-select" value="{{ request('date') }}" onchange="this.form.submit()">
        </form>
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Department</th>
            <th>Date & Time</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($appointments as $appt)
          @php
            $statusBadge = match($appt->status) {
              'confirmed'   => 'badge-green',
              'in_progress' => 'badge-blue',
              'pending'     => 'badge-amber',
              'cancelled'   => 'badge-red',
              default       => 'badge-gray',
            };
            $initials = strtoupper(substr($appt->patient_name ?? 'PA', 0, 1) . substr(explode(' ', $appt->patient_name ?? 'PA ')[1] ?? 'A', 0, 1));
          @endphp
          <tr>
            <td style="color:var(--text-muted);font-size:0.8rem">#APT-{{ str_pad($appt->id, 4, '0', STR_PAD_LEFT) }}</td>
            <td>
              <div class="user-cell">
                <div class="avatar av-green" style="width:30px;height:30px;font-size:0.7rem">{{ $initials }}</div>
                <span style="font-weight:500;font-size:0.875rem">{{ $appt->patient_name }}</span>
              </div>
            </td>
            <td style="color:var(--text-secondary)">{{ $appt->doctor ? 'Dr. '.$appt->doctor : '—' }}</td>
            <td><span class="badge badge-green">{{ $appt->department }}</span></td>
            <td style="color:var(--text-secondary);font-size:0.85rem">
              {{ $appt->date ? $appt->date->format('d M Y') : '—' }}{{ $appt->time ? ' — '.$appt->time : '' }}
            </td>
            <td><span class="badge {{ $statusBadge }}">{{ ucfirst(str_replace('_', ' ', $appt->status ?? 'pending')) }}</span></td>
            <td>
              <form method="POST" action="{{ route('admin.appointments.destroy', $appt->id) }}" onsubmit="return confirm('Delete this appointment?')" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="action-btn danger">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted)">No appointments found.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="pagination">
        <span class="pagination-info">Showing {{ $appointments->firstItem() ?? 0 }}–{{ $appointments->lastItem() ?? 0 }} of {{ $appointments->total() }} appointments</span>
        <div class="pagination-btns">
          @if($appointments->onFirstPage())
            <button class="pg-btn" disabled>‹</button>
          @else
            <a href="{{ $appointments->previousPageUrl() }}" class="pg-btn">‹</a>
          @endif
          @foreach($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="pg-btn {{ $page == $appointments->currentPage() ? 'active' : '' }}">{{ $page }}</a>
          @endforeach
          @if($appointments->hasMorePages())
            <a href="{{ $appointments->nextPageUrl() }}" class="pg-btn">›</a>
          @else
            <button class="pg-btn" disabled>›</button>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endsection


