@extends('admin.layout')
@section('title', 'Doctor')
@section('content')

  <div class="page-content active" id="page-doctors">
    <div class="page-header">
      <div class="page-header-left">
        <h1>Manage Doctors</h1>
        <p>47 specialists across 6 departments.</p>
      </div>
              <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
              <div class="nav-icon">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                  </svg>
              </div>
              Add Doctor
          </a>
    </div>

    <div class="table-card">
      <div class="search-bar">
        <form method="GET" action="{{ route('admin.doctors.index') }}" style="display:contents">
          <div class="search-input-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or specialisation…">
          </div>
          @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
          @if(request('department'))<input type="hidden" name="department" value="{{ request('department') }}">@endif
        </form>
        <div class="status-filter">
          <a href="{{ route('admin.doctors.index', array_merge(request()->except('status','page'), [])) }}"
             class="status-tab {{ !request('status') ? 'active' : '' }}">All</a>
          <a href="{{ route('admin.doctors.index', array_merge(request()->except('status','page'), ['status'=>'available'])) }}"
             class="status-tab {{ request('status')==='available' ? 'active' : '' }}">Available</a>
          <a href="{{ route('admin.doctors.index', array_merge(request()->except('status','page'), ['status'=>'onleave'])) }}"
             class="status-tab {{ request('status')==='onleave' ? 'active' : '' }}">On Leave</a>
        </div>
        <form method="GET" action="{{ route('admin.doctors.index') }}" style="margin-left:auto">
          @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
          @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
          <select name="department" class="filter-select" onchange="this.form.submit()">
            <option value="">All Departments</option>
            @foreach(['General Health','Cardiology','Dental','Neurology','Orthopaedics'] as $dept)
              <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
            @endforeach
          </select>
        </form>
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th>Doctor</th>
            <th>Specialisation</th>
            <th>Patients</th>
            <th>Rating</th>
            <th>Schedule Load</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($doctors as $doctor)
          <tr>
            <td>
              <div class="user-cell">
                <div class="avatar av-green">{{ strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1)) }}</div>
                <div>
                  <div class="user-name">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</div>
                  <div class="user-email">{{ $doctor->email }}</div>
                </div>
              </div>
            </td>
            <td><span class="badge badge-blue">{{ $doctor->specialization }}</span></td>
            <td style="color:var(--text-secondary);font-weight:500">—</td>
            <td><span style="color:var(--amber);font-weight:600">—</span></td>
            <td>
              <div class="progress-wrap" style="width:120px">
                <div class="progress-bg"><div class="progress-fill" style="width:{{ $doctor->schedule_load }}%;background:var(--green)"></div></div>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">{{ $doctor->schedule_load }}% full</div>
              </div>
            </td>
            <td>
              <span class="badge {{ $doctor->status === 'available' ? 'badge-green' : ($doctor->status === 'onleave' ? 'badge-amber' : 'badge-red') }}">
                {{ ucfirst($doctor->status) }}
              </span>
            </td>
            <td>
              <div style="display:flex;gap:8px;align-items:center;">
                <a href="{{ route('admin.doctors.edit', $doctor->DoctorID) }}" class="action-btn">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.doctors.destroy', $doctor->DoctorID) }}" onsubmit="return confirm('Delete this doctor?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="action-btn danger">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted)">No doctors found.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="pagination">
        <span class="pagination-info">Showing {{ $doctors->firstItem() ?? 0 }}–{{ $doctors->lastItem() ?? 0 }} of {{ $doctors->total() }} doctors</span>
        <div class="pagination-btns">
          @if($doctors->onFirstPage())
            <button class="pg-btn" disabled>‹</button>
          @else
            <a href="{{ $doctors->previousPageUrl() }}" class="pg-btn">‹</a>
          @endif

          @foreach($doctors->getUrlRange(1, $doctors->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="pg-btn {{ $page == $doctors->currentPage() ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($doctors->hasMorePages())
            <a href="{{ $doctors->nextPageUrl() }}" class="pg-btn">›</a>
          @else
            <button class="pg-btn" disabled>›</button>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection


