@extends('admin.layout')
@section('title', 'Patients')
@section('content')
<div class="page-content active" id="page-patients">
  <div class="page-header">
    <div class="page-header-left">
      <h1>Manage Patients</h1>
      <p>1,284 registered patients in the system.</p>
    </div>
    <a href="{{route('admin.patients.create')}}" class="btn btn-primary {{ request()->routeIs('admin.patients.create') ? 'active' : '' }}">
      <div class="nav-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
      </div>
      Add Patient
    </a>
  </div>

  <div class="table-card">
    <div class="search-bar">
      <div class="search-input-wrap">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <form method="GET" action="{{ route('admin.patients.index') }}">
          <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search patients...">
        </form>
      </div>
      <div class="status-filter">
        <a href="{{ route('admin.patients.index') }}"
          class="status-tab {{ request('status') == null ? 'active' : '' }}">
          All
        </a>

        <a href="{{ route('admin.patients.index', ['status' => 'active']) }}"
          class="status-tab {{ request('status') == 'active' ? 'active' : '' }}">
          Active
        </a>

        <a href="{{ route('admin.patients.index', ['status' => 'inactive']) }}"
          class="status-tab {{ request('status') == 'inactive' ? 'active' : '' }}">
          Inactive
        </a>
      </div>
      <button class="btn btn-outline" style="margin-left:auto">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        Export
      </button>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Patient</th>
          <th>Phone</th>
          <th>Date of Birth</th>
          <th>Department</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($patients as $patient)
        <tr>
          <td>
            <div class="user-cell">
              <div class="avatar av-green">
                {{ strtoupper(substr($patient->first_name ?? 'PP', 0, 2)) }}
              </div>
              <div>
                <div class="user-name">{{ $patient->last_name }} </div>
                <div class="user-email">{{ $patient->email }}</div>
              </div>
            </div>
          </td>

          <td style="color:var(--text-secondary)">{{ $patient->phone }}</td>

          <td style="color:var(--text-secondary)">
            {{ $patient->updated_at ? $patient->updated_at->format('d M Y') : 'N/A' }}
          </td>

          <td>
            <span class="badge badge-green">{{ $patient->department ?? 'General' }}</span>
          </td>

          <td>
            <span class="badge {{ ($patient->status == 'active') ? 'badge-green' : 'badge-red' }}">
              {{ ucfirst($patient->status ?? 'active') }}
            </span>
          </td>

          <td>
            <div style="display:flex; gap:8px;">

              
              <a href="{{ route('admin.patients.edit', $patient->user_id) }}" class="action-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
      <span class="pagination-info">Showing 1â€“5 of 1,284 patients</span>
      <div class="pagination-btns">
        <button class="pg-btn">â€¹</button>
        <button class="pg-btn active">1</button>
        <button class="pg-btn">2</button>
        <button class="pg-btn">3</button>
        <button class="pg-btn">â€¦</button>
        <button class="pg-btn">257</button>
        <button class="pg-btn">â€º</button>
      </div>
    </div>
  </div>
</div>

@endsection


