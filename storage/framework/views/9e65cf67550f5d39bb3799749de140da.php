<?php $__env->startSection('title', 'Appointments'); ?>

<?php $__env->startSection('content'); ?>

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
             <a href="<?php echo e(route('admin.appointments.create')); ?>" class="btn btn-primary">
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
        <div class="search-input-wrap">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          <input type="text" placeholder="Search appointments…">
        </div>
        <div class="status-filter">
          <button class="status-tab active">All</button>
          <button class="status-tab">Confirmed</button>
          <button class="status-tab">Pending</button>
          <button class="status-tab">Cancelled</button>
        </div>
        <input type="date" class="filter-select" style="margin-left:auto" value="2026-03-27">
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
          <tr>
            <td style="color:var(--text-muted);font-size:0.8rem">#APT-0241</td>
            <td><div class="user-cell"><div class="avatar av-green" style="width:30px;height:30px;font-size:0.7rem">SJ</div><span style="font-weight:500;font-size:0.875rem">Sarah Johnson</span></div></td>
            <td style="color:var(--text-secondary)">Dr. Rebecca Steffany</td>
            <td><span class="badge badge-green">General</span></td>
            <td style="color:var(--text-secondary);font-size:0.85rem">27 Mar 2026 — 09:00</td>
            <td><span class="badge badge-green">Confirmed</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button></td>
          </tr>
          <tr>
            <td style="color:var(--text-muted);font-size:0.8rem">#APT-0242</td>
            <td><div class="user-cell"><div class="avatar av-blue" style="width:30px;height:30px;font-size:0.7rem">MT</div><span style="font-weight:500;font-size:0.875rem">Michael Torres</span></div></td>
            <td style="color:var(--text-secondary)">Dr. Stein Albert</td>
            <td><span class="badge badge-blue">Cardiology</span></td>
            <td style="color:var(--text-secondary);font-size:0.85rem">27 Mar 2026 — 09:30</td>
            <td><span class="badge badge-blue">In Progress</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button></td>
          </tr>
          <tr>
            <td style="color:var(--text-muted);font-size:0.8rem">#APT-0243</td>
            <td><div class="user-cell"><div class="avatar av-pink" style="width:30px;height:30px;font-size:0.7rem">EW</div><span style="font-weight:500;font-size:0.875rem">Emily Watson</span></div></td>
            <td style="color:var(--text-secondary)">Dr. Alexa Melvin</td>
            <td><span class="badge badge-amber">Dental</span></td>
            <td style="color:var(--text-secondary);font-size:0.85rem">27 Mar 2026 — 10:15</td>
            <td><span class="badge badge-amber">Pending</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button></td>
          </tr>
          <tr>
            <td style="color:var(--text-muted);font-size:0.8rem">#APT-0244</td>
            <td><div class="user-cell"><div class="avatar av-red" style="width:30px;height:30px;font-size:0.7rem">LK</div><span style="font-weight:500;font-size:0.875rem">Linda Kim</span></div></td>
            <td style="color:var(--text-secondary)">Dr. Marcus Webb</td>
            <td><span class="badge badge-gray">Orthopaedics</span></td>
            <td style="color:var(--text-secondary);font-size:0.85rem">27 Mar 2026 — 14:00</td>
            <td><span class="badge badge-red">Cancelled</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <span class="pagination-info">Showing 1–4 of 24 appointments today</span>
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
  <?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/appointments/index.blade.php ENDPATH**/ ?>