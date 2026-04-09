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
        <div class="search-input-wrap">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          <input type="text" placeholder="Search by name or specialisation…">
        </div>
        <div class="status-filter">
          <button class="status-tab active">All</button>
          <button class="status-tab">Available</button>
          <button class="status-tab">On Leave</button>
        </div>
        <select class="filter-select" style="margin-left:auto">
          <option>All Departments</option>
          <option>General Health</option>
          <option>Cardiology</option>
          <option>Dental</option>
          <option>Neurology</option>
          <option>Orthopaedics</option>
        </select>
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
          <tr>
            <td><div class="user-cell"><div class="avatar av-green">SA</div><div><div class="user-name">Dr. Stein Albert</div><div class="user-email">s.albert@onehealth.com</div></div></div></td>
            <td><span class="badge badge-blue">Cardiology</span></td>
            <td style="color:var(--text-secondary);font-weight:500">312</td>
            <td><span style="color:var(--amber);font-weight:600">★ 4.9</span></td>
            <td><div class="progress-wrap" style="width:120px"><div class="progress-bg"><div class="progress-fill" style="width:85%;background:var(--red)"></div></div><div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">85% full</div></div></td>
            <td><span class="badge badge-green">Available</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
          <tr>
            <td><div class="user-cell"><div class="avatar av-pink">AM</div><div><div class="user-name">Dr. Alexa Melvin</div><div class="user-email">a.melvin@onehealth.com</div></div></div></td>
            <td><span class="badge badge-amber">Dental</span></td>
            <td style="color:var(--text-secondary);font-weight:500">198</td>
            <td><span style="color:var(--amber);font-weight:600">★ 4.8</span></td>
            <td><div class="progress-wrap" style="width:120px"><div class="progress-bg"><div class="progress-fill" style="width:60%;background:var(--amber)"></div></div><div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">60% full</div></div></td>
            <td><span class="badge badge-green">Available</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
          <tr>
            <td><div class="user-cell"><div class="avatar av-blue">RS</div><div><div class="user-name">Dr. Rebecca Steffany</div><div class="user-email">r.steffany@onehealth.com</div></div></div></td>
            <td><span class="badge badge-green">General Health</span></td>
            <td style="color:var(--text-secondary);font-weight:500">445</td>
            <td><span style="color:var(--amber);font-weight:600">★ 4.7</span></td>
            <td><div class="progress-wrap" style="width:120px"><div class="progress-bg"><div class="progress-fill" style="width:40%;background:var(--green)"></div></div><div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">40% full</div></div></td>
            <td><span class="badge badge-green">Available</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
          <tr>
            <td><div class="user-cell"><div class="avatar av-purple">PN</div><div><div class="user-name">Dr. Pham Nguyen</div><div class="user-email">p.nguyen@onehealth.com</div></div></div></td>
            <td><span class="badge badge-purple">Neurology</span></td>
            <td style="color:var(--text-secondary);font-weight:500">187</td>
            <td><span style="color:var(--amber);font-weight:600">★ 4.9</span></td>
            <td><div class="progress-wrap" style="width:120px"><div class="progress-bg"><div class="progress-fill" style="width:75%;background:var(--amber)"></div></div><div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">75% full</div></div></td>
            <td><span class="badge badge-amber">On Leave</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <span class="pagination-info">Showing 1–4 of 47 doctors</span>
        <div class="pagination-btns">
          <button class="pg-btn">‹</button>
          <button class="pg-btn active">1</button>
          <button class="pg-btn">2</button>
          <button class="pg-btn">3</button>
          <button class="pg-btn">›</button>
        </div>
      </div>
    </div>
  </div>
@endsection