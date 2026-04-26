@extends('admin.layout')
@section('title', 'Patients')
@section('content')
<div class="page-content active" id="page-patients">
  <div class="page-header">
    <div class="page-header-left">
      <h1>Manage Patients</h1>
      <p>{{ $patients->total() }} registered patients in the system.</p>
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
        <form method="GET" action="{{ route('admin.patients.index') }}" style="display:contents">
          @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
          <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search patients...">
        </form>
      </div>
      <div class="status-filter">
        <a href="{{ route('admin.patients.index', array_merge(request()->except('status','page'), [])) }}"
          class="status-tab {{ request('status') == null ? 'active' : '' }}">
          All
        </a>
        <a href="{{ route('admin.patients.index', array_merge(request()->except('status','page'), ['status'=>'active'])) }}"
          class="status-tab {{ request('status') == 'active' ? 'active' : '' }}">
          Active
        </a>
        <a href="{{ route('admin.patients.index', array_merge(request()->except('status','page'), ['status'=>'inactive'])) }}"
          class="status-tab {{ request('status') == 'inactive' ? 'active' : '' }}">
          Inactive
        </a>
      </div>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Patient</th>
          <th>Phone</th>
          <th>Date of Birth</th>
          <th>Gender</th>
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
                {{ strtoupper(substr($patient->user->name ?? 'P', 0, 2)) }}
              </div>
              <div>
                <div class="user-name">{{ $patient->user->name ?? 'N/A' }}</div>
                <div class="user-email">{{ $patient->user->email ?? 'N/A' }}</div>
              </div>
            </div>
          </td>

          <td style="color:var(--text-secondary)">{{ $patient->phone }}</td>

          <td style="color:var(--text-secondary)">
            {{ $patient->date_of_birth ? $patient->date_of_birth->format('d M Y') : 'N/A' }}
          </td>

          <td>
            <span class="badge badge-green">{{ ucfirst($patient->gender ?? 'N/A') }}</span>
          </td>

          <td>
            @php($status = $patient->user->status ?? 'active')
            <span class="badge {{ ($status === 'active') ? 'badge-green' : 'badge-red' }}">
              {{ ucfirst($status) }}
            </span>
          </td>

          <td>
            <div style="display:flex; gap:8px;">

              
              <a href="{{ route('admin.patients.edit', $patient->id) }}" class="action-btn">
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
      <span class="pagination-info">Showing {{ $patients->firstItem() }}&ndash;{{ $patients->lastItem() }} of {{ $patients->total() }} patients</span>
      <div class="pagination-btns">
        @if($patients->onFirstPage())
          <button class="pg-btn" disabled>&lsaquo;</button>
        @else
          <a href="{{ $patients->previousPageUrl() }}" class="pg-btn">&lsaquo;</a>
        @endif

        @foreach($patients->getUrlRange(1, $patients->lastPage()) as $page => $url)
          <a href="{{ $url }}" class="pg-btn {{ $page == $patients->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach

        @if($patients->hasMorePages())
          <a href="{{ $patients->nextPageUrl() }}" class="pg-btn">&rsaquo;</a>
        @else
          <button class="pg-btn" disabled>&rsaquo;</button>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
