@extends('layout.main')

@push('style')
<style>
  .db-wrap {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
  }

  .db-hero {
    background: #0d2137;
    padding: 48px 0 56px;
    border-bottom: 1px solid #162a44;
  }
  .db-hero h1 {
    color: #fff;
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0 0 4px;
  }
  .db-hero p {
    color: #94a3b8;
    margin: 0;
    font-size: .9rem;
  }

  .db-body {
    background: #f4f6f9;
    padding-bottom: 60px;
  }

  .db-pull-up {
    margin-top: -28px;
    position: relative;
    z-index: 10;
  }

  .db-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
  }
  .db-stat {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    cursor: pointer;
    border: 2px solid transparent;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    transition: border-color .15s, box-shadow .15s;
  }
  .db-stat:hover { box-shadow: 0 4px 14px rgba(0,0,0,.1); }
  .db-stat.is-active { border-color: #1a8a6e; }
  .db-stat-ico {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .db-stat-ico.c-green { background: #e8f7f3; }
  .db-stat-ico.c-blue  { background: #eff6ff; }
  .db-stat-ico.c-amber { background: #fffbeb; }
  .db-stat-ico.c-rose  { background: #fff1f2; }
  .db-stat-num { font-size: 1.45rem; font-weight: 700; color: #18243a; line-height: 1; }
  .db-stat-lbl { font-size: .78rem; color: #94a3b8; margin-top: 3px; }

  .db-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
  }

  .db-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    padding: 24px;
  }
  .db-card-title {
    font-size: .95rem;
    font-weight: 600;
    color: #18243a;
    margin: 0 0 18px;
  }

  .db-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  .db-action {
    padding: 16px;
    border-radius: 9px;
    text-decoration: none;
    color: #18243a;
    border: 1px solid #e9edf3;
    background: #fff;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: box-shadow .15s, border-color .15s;
  }
  .db-action:hover { box-shadow: 0 3px 12px rgba(0,0,0,.08); border-color: #cbd5e1; color: #18243a; }
  .db-action-ico {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
  }
  .db-action strong { font-size: .87rem; display: block; }
  .db-action span { font-size: .78rem; color: #94a3b8; margin-top: 2px; display: block; }

  .db-panel { display: none; margin-top: 18px; }
  .db-panel.is-active { display: block; }

  .db-list { display: flex; flex-direction: column; gap: 10px; }
  .db-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: #f8fafc;
    border-radius: 9px;
    border: 1px solid #f0f3f7;
  }
  .db-item-ico {
    width: 40px;
    height: 40px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .db-item-body { flex: 1; min-width: 0; }
  .db-item-title { font-weight: 600; font-size: .88rem; color: #18243a; }
  .db-item-sub { font-size: .78rem; color: #94a3b8; margin-top: 2px; }
  .db-badge {
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    white-space: nowrap;
  }
  .badge-confirmed { background: #e8f7f3; color: #1a8a6e; }
  .badge-pending   { background: #fffbeb; color: #d97706; }
  .badge-cancelled { background: #fef2f2; color: #dc2626; }
  .badge-active    { background: #eff6ff; color: #2563eb; }

  .db-empty {
    text-align: center;
    padding: 40px 16px;
    color: #94a3b8;
    font-size: .88rem;
  }
  .db-empty svg { margin-bottom: 10px; opacity: .35; }
  .db-empty a { color: #1a8a6e; font-weight: 600; }

  .db-profile-initial {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #1a8a6e;
    color: #fff;
    font-size: 1.6rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
  }
  .db-name  { font-size: 1rem; font-weight: 700; color: #18243a; text-align: center; margin: 0 0 2px; }
  .db-email { font-size: .8rem; color: #94a3b8; text-align: center; margin: 0 0 14px; }
  .db-role-tag {
    display: inline-block;
    background: #e8f7f3;
    color: #1a8a6e;
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 18px;
  }

  @media (max-width: 1100px) {
    .db-stats  { grid-template-columns: repeat(2, 1fr); }
    .db-layout { grid-template-columns: 1fr 260px; }
  }
  @media (max-width: 820px) {
    .db-layout { grid-template-columns: 1fr; }
  }
  @media (max-width: 560px) {
    .db-actions { grid-template-columns: 1fr; }
    .db-wrap    { padding: 0 16px; }
  }
</style>
@endpush

@section('content')

@if(session('success') || session('error'))
<div id="flash-msg" style="position:fixed;top:24px;right:24px;z-index:9999;background:{{ session('success') ? '#1a8a6e' : '#dc2626' }};color:#fff;padding:14px 20px;border-radius:10px;font-size:.9rem;font-weight:500;box-shadow:0 6px 24px rgba(0,0,0,.15);max-width:380px;display:flex;align-items:center;gap:10px;opacity:0;transform:translateY(-8px);transition:all .35s ease">
  <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
    @if(session('success'))
    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    @else
    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
    @endif
  </svg>
  {{ session('success') ?? session('error') }}
</div>
<script>
  (function() {
    var el = document.getElementById('flash-msg');
    if (!el) return;
    setTimeout(function() { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; }, 80);
    setTimeout(function() { el.style.opacity = '0'; }, 4000);
    setTimeout(function() { el.remove(); }, 4400);
  })();
</script>
@endif

<div class="db-hero">
  <div class="db-wrap">
    <h1>Hello, {{ Auth::user()->name }}</h1>
    <p>Your health summary for {{ now()->format('l, d F Y') }}</p>
  </div>
</div>

<div class="db-body">
  <div class="db-pull-up">
    <div class="db-wrap">

      <div class="db-stats">
        <div class="db-stat is-active" data-tab="appointments" onclick="dbTab('appointments')">
          <div class="db-stat-ico c-green">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1a8a6e" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <div class="db-stat-num">{{ $appointments->where('status', '!=', 'cancelled')->count() }}</div>
            <div class="db-stat-lbl">Appointments</div>
          </div>
        </div>

        <div class="db-stat" data-tab="prescriptions" onclick="dbTab('prescriptions')">
          <div class="db-stat-ico c-blue">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
          <div>
            <div class="db-stat-num">{{ $prescriptions->count() }}</div>
            <div class="db-stat-lbl">Prescriptions</div>
          </div>
        </div>

        <div class="db-stat" data-tab="records" onclick="dbTab('records')">
          <div class="db-stat-ico c-amber">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div>
            <div class="db-stat-num">{{ $medicalRecords->count() }}</div>
            <div class="db-stat-lbl">Medical Records</div>
          </div>
        </div>

        <div class="db-stat" data-tab="messages" onclick="dbTab('messages')">
          <div class="db-stat-ico c-rose">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#e11d48" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
          </div>
          <div>
            <div class="db-stat-num">{{ $unreadMessages->count() }}</div>
            <div class="db-stat-lbl">Unread Messages</div>
          </div>
        </div>
      </div>

      <div class="db-layout">

        <div>
          <div class="db-card">
            <p class="db-card-title">Quick Actions</p>
            <div class="db-actions">
              <a href="{{ route('home') }}#appointment" class="db-action">
                <div class="db-action-ico" style="background:#e8f7f3">
                  <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#1a8a6e" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <div>
                  <strong>Book Appointment</strong>
                  <span>Schedule a visit</span>
                </div>
              </a>
              <a href="{{ route('home') }}#our_doctor" class="db-action">
                <div class="db-action-ico" style="background:#eff6ff">
                  <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
                <div>
                  <strong>Find a Doctor</strong>
                  <span>Browse specialists</span>
                </div>
              </a>
              <a href="{{ route('patient.chat') }}" class="db-action">
                <div class="db-action-ico" style="background:#fff7ed">
                  <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                  </svg>
                </div>
                <div>
                  <strong>Message a Doctor</strong>
                  <span>Ask a question</span>
                </div>
              </a>
              <a href="{{ route('patient.records') }}" class="db-action">
                <div class="db-action-ico" style="background:#f5f3ff">
                  <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#7c3aed" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <div>
                  <strong>My Records</strong>
                  <span>Medical history</span>
                </div>
              </a>
              <a href="{{ route('patient.lab-test') }}" class="db-action">
                <div class="db-action-ico" style="background:#fef2f2">
                  <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                  </svg>
                </div>
                <div>
                  <strong>Lab Test</strong>
                  <span>Book a test</span>
                </div>
              </a>
              <a href="{{ route('patient.lab-results') }}" class="db-action">
                <div class="db-action-ico" style="background:#ecfdf5">
                  <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#059669" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                  </svg>
                </div>
                <div>
                  <strong>Lab Results</strong>
                  <span>View test results</span>
                </div>
              </a>
            </div>
          </div>

          <div class="db-panel is-active" id="panel-appointments">
            <div class="db-card">
              <p class="db-card-title">Upcoming Appointments</p>
              @if($appointments->isEmpty())
              <div class="db-empty">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>No appointments scheduled.<br><a href="{{ route('home') }}#appointment">Book one now &rarr;</a></p>
              </div>
              @else
              <div class="db-list">
                @foreach($appointments as $appt)
                <div class="db-item">
                  <div class="db-item-ico" style="background:{{ $appt->status === 'confirmed' ? '#e8f7f3' : ($appt->status === 'cancelled' ? '#fef2f2' : '#fffbeb') }}">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="{{ $appt->status === 'confirmed' ? '#1a8a6e' : ($appt->status === 'cancelled' ? '#dc2626' : '#d97706') }}" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <div class="db-item-body">
                    <div class="db-item-title">{{ $appt->department }}</div>
                    <div class="db-item-sub">
                      {{ $appt->date->format('d M Y') }}{{ $appt->time ? ', '.$appt->time : '' }}
                      @if($appt->doctor) &mdash; Dr. {{ $appt->doctor }}@endif
                    </div>
                  </div>
                  <span class="db-badge badge-{{ $appt->status === 'confirmed' ? 'confirmed' : ($appt->status === 'cancelled' ? 'cancelled' : 'pending') }}">
                    {{ ucfirst($appt->status) }}
                  </span>
                </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>

          <div class="db-panel" id="panel-prescriptions">
            <div class="db-card">
              <p class="db-card-title">Prescriptions</p>
              @if($prescriptions->isEmpty())
              <div class="db-empty">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p>No active prescriptions.</p>
              </div>
              @else
              <div class="db-list">
                @foreach($prescriptions as $rx)
                <div class="db-item">
                  <div class="db-item-ico" style="background:#eff6ff">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                  </div>
                  <div class="db-item-body">
                    <div class="db-item-title">{{ $rx->medication }}</div>
                    <div class="db-item-sub">{{ $rx->dosage }} &mdash; {{ $rx->frequency }}</div>
                    <div class="db-item-sub">Dr. {{ $rx->doctor_name }} &middot; {{ $rx->start_date->format('d M Y') }}{{ $rx->end_date ? ' to '.$rx->end_date->format('d M Y') : '' }}</div>
                  </div>
                  <span class="db-badge badge-active">Active</span>
                </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>

          <div class="db-panel" id="panel-records">
            <div class="db-card">
              <p class="db-card-title">Medical Records</p>
              @if($medicalRecords->isEmpty())
              <div class="db-empty">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>No medical records found.</p>
              </div>
              @else
              <div class="db-list">
                @foreach($medicalRecords as $record)
                <div class="db-item">
                  <div class="db-item-ico" style="background:#fffbeb">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                  </div>
                  <div class="db-item-body">
                    <div class="db-item-title">{{ $record->title }}</div>
                    <div class="db-item-sub">{{ ucfirst($record->type) }} &middot; {{ $record->department }}</div>
                    <div class="db-item-sub">Dr. {{ $record->doctor_name }} &middot; {{ $record->record_date->format('d M Y') }}</div>
                  </div>
                </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>

          <div class="db-panel" id="panel-messages">
            <div class="db-card">
              <p class="db-card-title">Unread Messages</p>
              @if($unreadMessages->isEmpty())
              <div class="db-empty">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <p>No unread messages.</p>
              </div>
              @else
              <div class="db-list">
                @foreach($unreadMessages as $msg)
                <div class="db-item">
                  <div class="db-item-ico" style="background:#fff1f2">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#e11d48" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <div class="db-item-body">
                    <div class="db-item-title">{{ $msg->subject }}</div>
                    <div class="db-item-sub">{{ Str::limit($msg->body, 80) }}</div>
                    <div class="db-item-sub">{{ $msg->created_at->diffForHumans() }}</div>
                  </div>
                  <span style="width:8px;height:8px;border-radius:50%;background:#e11d48;flex-shrink:0"></span>
                </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>

        </div>

        <div>
          <div class="db-card" style="text-align:center">
            <div class="db-profile-initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <p class="db-name">{{ Auth::user()->name }}</p>
            <p class="db-email">{{ Auth::user()->email }}</p>
            <span class="db-role-tag">Patient</span>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="width:100%;justify-content:center;padding:10px 0;font-size:.88rem;border-radius:8px">Edit Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:8px">
              @csrf
              <button type="submit" class="btn" style="width:100%;padding:10px 0;font-size:.88rem;border-radius:8px;background:#f1f5f9;color:#64748b;border:none">Log Out</button>
            </form>
          </div>

          <div class="db-card" style="margin-top:16px">
            <p class="db-card-title" style="margin-bottom:10px">Your info</p>
            <div style="display:flex;flex-direction:column;gap:8px">
              <div style="display:flex;justify-content:space-between;font-size:.82rem">
                <span style="color:#94a3b8">Phone</span>
                <span style="color:#18243a;font-weight:500">{{ Auth::user()->phone ?? '—' }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:.82rem">
                <span style="color:#94a3b8">Member since</span>
                <span style="color:#18243a;font-weight:500">{{ Auth::user()->created_at->format('M Y') }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:.82rem">
                <span style="color:#94a3b8">Status</span>
                <span style="color:#1a8a6e;font-weight:600">Active</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function dbTab(name) {
  document.querySelectorAll('.db-stat').forEach(function(el) { el.classList.remove('is-active'); });
  document.querySelectorAll('.db-panel').forEach(function(el) { el.classList.remove('is-active'); });
  document.querySelector('[data-tab="' + name + '"]').classList.add('is-active');
  document.getElementById('panel-' + name).classList.add('is-active');
}
</script>
@endsection
