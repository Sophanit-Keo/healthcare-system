<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-content active" id="page-dashboard">

  <div class="page-header">
    <div class="page-header-left">
      <h1>Welcome, <?php echo e(Auth::user()->name); ?></h1>
      <p><?php echo e(now()->format('l, d F Y')); ?> &mdash; here's your overview.</p>
    </div>
    <a href="<?php echo e(route('admin.appointments.create')); ?>" class="btn btn-primary">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      New Appointment
    </a>
  </div>

  <div class="stats-grid">
    <div class="stat-card c-green">
      <div class="stat-card-top">
        <div class="stat-icon green">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <span class="stat-trend up">↑ 12.4%</span>
      </div>
      <div>
        <div class="stat-value">48,284</div>
        <div class="stat-label">Total Patients</div>
      </div>
    </div>

    <div class="stat-card c-blue">
      <div class="stat-card-top">
        <div class="stat-icon blue">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <span class="stat-trend up">↑ 8.1%</span>
      </div>
      <div>
        <div class="stat-value">1,340</div>
        <div class="stat-label">Appointments This Month</div>
      </div>
    </div>

    <div class="stat-card c-amber">
      <div class="stat-card-top">
        <div class="stat-icon amber">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <span class="stat-trend up">↑ 5.7%</span>
      </div>
      <div>
        <div class="stat-value">$84,320</div>
        <div class="stat-label">Revenue This Month</div>
      </div>
    </div>

    <div class="stat-card c-purple">
      <div class="stat-card-top">
        <div class="stat-icon purple">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <span class="stat-trend down">↓ 2.0%</span>
      </div>
      <div>
        <div class="stat-value">47</div>
        <div class="stat-label">Active Doctors</div>
      </div>
    </div>
  </div>

  <div class="charts-row">
    <div class="chart-card">
      <div class="chart-header">
        <div>
          <div class="chart-title">Patient Growth & Revenue</div>
          <div class="chart-subtitle">Monthly overview for 2026</div>
        </div>
        <div class="chart-tabs">
          <button class="chart-tab active">Patients</button>
          <button class="chart-tab">Revenue</button>
        </div>
      </div>
      <canvas id="mainChart" height="90"></canvas>
    </div>

    <div class="chart-card">
      <div class="chart-header">
        <div>
          <div class="chart-title">Appointments by Department</div>
          <div class="chart-subtitle">This month</div>
        </div>
      </div>
      <div class="donut-wrap">
        <canvas id="donutChart"></canvas>
        <div class="donut-center">
          <div class="donut-num">1,340</div>
          <div class="donut-lbl">Total</div>
        </div>
      </div>
      <div class="legend-list">
        <div class="legend-item">
          <div class="legend-dot" style="background:#1A8A6E"></div>
          <div class="legend-name">General Health</div>
          <div class="legend-val">38%</div>
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background:#2563EB"></div>
          <div class="legend-name">Cardiology</div>
          <div class="legend-val">24%</div>
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background:#D97706"></div>
          <div class="legend-name">Dental</div>
          <div class="legend-val">20%</div>
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background:#7C3AED"></div>
          <div class="legend-name">Neurology</div>
          <div class="legend-val">18%</div>
        </div>
      </div>
    </div>
  </div>

  <div class="bottom-row">

    <div class="table-card">
      <div class="table-header">
        <div>
          <div class="table-title">Today's Appointments</div>
          <div class="table-subtitle"><?php echo e(now()->format('l, d F Y')); ?></div>
        </div>
        <span class="badge badge-green">24 scheduled</span>
      </div>
      <div class="appt-list">
        <div class="appt-item">
          <div class="appt-time">09:00</div>
          <div class="appt-dot" style="background:var(--green)"></div>
          <div class="appt-info">
            <div class="appt-name">Sarah Johnson</div>
            <div class="appt-dept">General Health — Dr. Rebecca Steffany</div>
          </div>
          <span class="badge badge-green">Confirmed</span>
        </div>
        <div class="appt-item">
          <div class="appt-time">09:30</div>
          <div class="appt-dot" style="background:var(--blue)"></div>
          <div class="appt-info">
            <div class="appt-name">Michael Torres</div>
            <div class="appt-dept">Cardiology — Dr. Stein Albert</div>
          </div>
          <span class="badge badge-blue">In Progress</span>
        </div>
        <div class="appt-item">
          <div class="appt-time">10:15</div>
          <div class="appt-dot" style="background:var(--amber)"></div>
          <div class="appt-info">
            <div class="appt-name">Emily Watson</div>
            <div class="appt-dept">Dental — Dr. Alexa Melvin</div>
          </div>
          <span class="badge badge-amber">Pending</span>
        </div>
        <div class="appt-item">
          <div class="appt-time">11:00</div>
          <div class="appt-dot" style="background:var(--purple)"></div>
          <div class="appt-info">
            <div class="appt-name">James O'Brien</div>
            <div class="appt-dept">Neurology — Dr. Pham Nguyen</div>
          </div>
          <span class="badge badge-green">Confirmed</span>
        </div>
        <div class="appt-item">
          <div class="appt-time">14:00</div>
          <div class="appt-dot" style="background:var(--red)"></div>
          <div class="appt-info">
            <div class="appt-name">Linda Kim</div>
            <div class="appt-dept">Orthopaedics — Dr. Marcus Webb</div>
          </div>
          <span class="badge badge-red">Cancelled</span>
        </div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-header">
        <div>
          <div class="table-title">Doctor Availability</div>
          <div class="table-subtitle">Today's schedule load</div>
        </div>
      </div>
      <div>
        <div class="avail-row">
          <div class="avatar av-green" style="width:36px;height:36px;font-size:0.75rem">SA</div>
          <div class="avail-info">
            <div class="avail-name">Dr. Stein Albert</div>
            <div class="avail-dept">Cardiology</div>
          </div>
          <div class="avail-bar-wrap">
            <div class="avail-bar-bg">
              <div class="avail-bar" style="width:85%;background:var(--red)"></div>
            </div>
            <div class="avail-pct">85% full</div>
          </div>
        </div>
        <div class="avail-row">
          <div class="avatar av-pink" style="width:36px;height:36px;font-size:0.75rem">AM</div>
          <div class="avail-info">
            <div class="avail-name">Dr. Alexa Melvin</div>
            <div class="avail-dept">Dental</div>
          </div>
          <div class="avail-bar-wrap">
            <div class="avail-bar-bg">
              <div class="avail-bar" style="width:60%;background:var(--amber)"></div>
            </div>
            <div class="avail-pct">60% full</div>
          </div>
        </div>
        <div class="avail-row">
          <div class="avatar av-blue" style="width:36px;height:36px;font-size:0.75rem">RS</div>
          <div class="avail-info">
            <div class="avail-name">Dr. Rebecca Steffany</div>
            <div class="avail-dept">General Health</div>
          </div>
          <div class="avail-bar-wrap">
            <div class="avail-bar-bg">
              <div class="avail-bar" style="width:40%;background:var(--green)"></div>
            </div>
            <div class="avail-pct">40% full</div>
          </div>
        </div>
        <div class="avail-row">
          <div class="avatar av-purple" style="width:36px;height:36px;font-size:0.75rem">PN</div>
          <div class="avail-info">
            <div class="avail-name">Dr. Pham Nguyen</div>
            <div class="avail-dept">Neurology</div>
          </div>
          <div class="avail-bar-wrap">
            <div class="avail-bar-bg">
              <div class="avail-bar" style="width:75%;background:var(--amber)"></div>
            </div>
            <div class="avail-pct">75% full</div>
          </div>
        </div>
        <div class="avail-row">
          <div class="avatar av-teal" style="width:36px;height:36px;font-size:0.75rem">MW</div>
          <div class="avail-info">
            <div class="avail-name">Dr. Marcus Webb</div>
            <div class="avail-dept">Orthopaedics</div>
          </div>
          <div class="avail-bar-wrap">
            <div class="avail-bar-bg">
              <div class="avail-bar" style="width:20%;background:var(--green)"></div>
            </div>
            <div class="avail-pct">20% full</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>