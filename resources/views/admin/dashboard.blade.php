@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')

<div class="page-content active" id="page-dashboard">

  <div class="page-header">
    <div class="page-header-left">
      <h1>Welcome, {{ Auth::user()->name }}</h1>
      <p>{{ now()->format('l, d F Y') }} &mdash; here's your overview.</p>
    </div>
    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
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
        <a href="{{ route('admin.patients.index') }}" class="stat-trend up">View</a>
      </div>
      <div>
        <div class="stat-value">{{ number_format($patientsCount) }}</div>
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
        <a href="{{ route('admin.appointments.index') }}" class="stat-trend up">View</a>
      </div>
      <div>
        <div class="stat-value">{{ number_format($appointmentsThisMonth) }}</div>
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
        <a href="{{ route('admin.encounters.index') }}" class="stat-trend up">View</a>
      </div>
      <div>
        <div class="stat-value">{{ number_format($encountersThisMonth) }}</div>
        <div class="stat-label">Encounters This Month</div>
      </div>
    </div>

    <div class="stat-card c-purple">
      <div class="stat-card-top">
        <div class="stat-icon purple">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <a href="{{ route('admin.doctors.index') }}" class="stat-trend up">View</a>
      </div>
      <div>
        <div class="stat-value">{{ number_format($activeDoctorsCount) }}</div>
        <div class="stat-label">Active Doctors</div>
      </div>
    </div>
  </div>

  <div class="charts-row">
    <div class="chart-card">
      <div class="chart-header">
        <div>
          <div class="chart-title">Appointment Activity</div>
          <div class="chart-subtitle">Last six months</div>
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
          <div class="donut-num">{{ number_format($departmentAppointments->sum('appointments_count')) }}</div>
          <div class="donut-lbl">Total</div>
        </div>
      </div>
      <div class="legend-list">
        @forelse($departmentAppointments as $index => $department)
          @php($colors = ['#1A8A6E','#2563EB','#D97706','#7C3AED','#DC2626'])
          <div class="legend-item"><div class="legend-dot" style="background:{{ $colors[$index] }}"></div><div class="legend-name">{{ $department->name }}</div><div class="legend-val">{{ $department->appointments_count }}</div></div>
        @empty
          <div class="legend-item"><div class="legend-name">No appointments this month</div></div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="bottom-row">

    <div class="table-card">
      <div class="table-header">
        <div>
          <div class="table-title">Today's Appointments</div>
          <div class="table-subtitle">{{ now()->format('l, d F Y') }}</div>
        </div>
        <span class="badge badge-green">{{ $todayAppointments->count() }} scheduled</span>
      </div>
      <div class="appt-list">
        @forelse($todayAppointments as $appointment)
          <a class="appt-item" href="{{ route('admin.appointments.show', $appointment) }}"><div class="appt-time">{{ substr((string) $appointment->appointment_time, 0, 5) }}</div><div class="appt-dot" style="background:var(--green)"></div><div class="appt-info"><div class="appt-name">{{ $appointment->patient?->user?->name ?? $appointment->patient_name }}</div><div class="appt-dept">{{ $appointment->departmentRef?->name ?? $appointment->department }} — {{ $appointment->staff ? trim($appointment->staff->first_name.' '.$appointment->staff->last_name) : ($appointment->doctor ?? 'Unassigned') }}</div></div><span class="badge badge-green">{{ ucfirst(str_replace('_',' ', $appointment->status)) }}</span></a>
        @empty
          <div class="appt-item"><div class="appt-info"><div class="appt-name">No appointments today</div></div></div>
        @endforelse
      </div>
    </div>

    <div class="table-card">
      <div class="table-header">
        <div>
          <div class="table-title">Recent Lab Orders</div>
          <div class="table-subtitle">Latest diagnostic activity</div>
        </div>
      </div>
      <div>
        @forelse($recentLabOrders as $order)
          <a class="avail-row" href="{{ route('admin.lab-orders.show', $order) }}"><div class="avatar av-blue" style="width:36px;height:36px;font-size:0.75rem">L{{ $order->id }}</div><div class="avail-info"><div class="avail-name">{{ $order->patient?->user?->name ?? 'Patient' }}</div><div class="avail-dept">Order #{{ $order->id }}</div></div><span class="badge badge-blue">{{ ucfirst(str_replace('_',' ', $order->status)) }}</span></a>
        @empty
          <div class="avail-row"><div class="avail-info"><div class="avail-name">No lab orders yet</div></div></div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@push('appadmin')
<script>
const chartColors = ['#1A8A6E','#2563EB','#D97706','#7C3AED','#DC2626'];
new Chart(document.getElementById('mainChart'), {type:'line',data:{labels:@json($monthlyAppointments->pluck('label')),datasets:[{label:'Appointments',data:@json($monthlyAppointments->pluck('count')),borderColor:'#1A8A6E',backgroundColor:'rgba(26,138,110,.12)',fill:true,tension:.35}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});
new Chart(document.getElementById('donutChart'), {type:'doughnut',data:{labels:@json($departmentAppointments->pluck('name')),datasets:[{data:@json($departmentAppointments->pluck('appointments_count')),backgroundColor:chartColors}]},options:{responsive:true,cutout:'72%',plugins:{legend:{display:false}}}});
</script>
@endpush
@endsection


