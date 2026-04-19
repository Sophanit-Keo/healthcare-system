@extends('layout.main')

@push('style')
<style>
  .dash-container { width:100%; max-width:1400px; margin:auto; padding:0 24px; }
  .dash-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; }
  .dash-stat-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:26px 24px; display:flex; align-items:center; gap:18px; transition:transform .18s,box-shadow .18s; cursor:pointer; user-select:none; border:2px solid transparent; }
  .dash-stat-card:hover { transform:translateY(-3px); box-shadow:0 6px 24px rgba(0,0,0,.1); }
  .dash-stat-card.active { border-color:#1a8a6e; box-shadow:0 4px 20px rgba(26,138,110,.18); }
  .dash-stat-icon { width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:24px; flex-shrink:0; }
  .dash-stat-icon.green { background:#e8f7f3; }
  .dash-stat-icon.blue  { background:#eef2ff; }
  .dash-stat-icon.amber { background:#fff7ed; }
  .dash-stat-icon.pink  { background:#fdf2f8; }
  .dash-stat-value { font-size:1.5rem; font-weight:700; color:#18243a; line-height:1; }
  .dash-stat-label { font-size:.82rem; color:#8898b0; margin-top:3px; }

  .dash-grid { display:grid; grid-template-columns:1fr 340px; gap:20px; }
  .dash-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:28px; }
  .dash-actions { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
  .dash-action { display:block; padding:20px; border-radius:12px; text-decoration:none; color:#0d2137; transition:transform .15s,box-shadow .15s; }
  .dash-action:hover { transform:translateY(-2px); box-shadow:0 4px 16px rgba(0,0,0,.08); }
  .dash-action strong { font-size:15px; display:block; }
  .dash-action p { font-size:13px; color:#8898b0; margin:4px 0 0; }

  .dash-profile-avatar { width:84px; height:84px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:34px; color:#fff; font-weight:600; }

  .dash-upcoming { margin-top:20px; }
  .dash-upcoming-title { font-size:1rem; font-weight:600; color:#18243a; margin-bottom:14px; }
  .dash-empty { text-align:center; padding:32px 16px; color:#8898b0; font-size:.9rem; }

  @media (max-width:1200px) {
    .dash-stats { grid-template-columns:repeat(2,1fr); }
    .dash-grid { grid-template-columns:1fr 300px; }
  }
  @media (max-width:900px) {
    .dash-grid { grid-template-columns:1fr; }
  }
  @media (max-width:600px) {
    .dash-stats { grid-template-columns:1fr; }
    .dash-actions { grid-template-columns:1fr; }
    .dash-container { padding:0 14px; }
    .dash-stat-card { padding:20px 16px; }
  }
</style>
@endpush

@section('content')
@if(session('success') || session('error'))
<div id="toast" style="position:fixed;top:30px;right:30px;z-index:9999;min-width:320px;max-width:420px;padding:18px 24px;border-radius:12px;color:#fff;font-weight:500;font-size:.95rem;box-shadow:0 8px 32px rgba(0,0,0,.18);display:flex;align-items:center;gap:12px;transform:translateX(120%);transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .4s;opacity:0;{{ session('success') ? 'background:linear-gradient(135deg,#1a8a6e,#12705a)' : 'background:linear-gradient(135deg,#dc2626,#b91c1c)' }}">
  <span style="font-size:22px">{{ session('success') ? 'âœ…' : 'âŒ' }}</span>
  <span>{{ session('success') ?? session('error') }}</span>
</div>
<script>
  document.addEventListener('DOMContentLoaded',function(){
    var t=document.getElementById('toast');
    if(t){setTimeout(function(){t.style.transform='translateX(0)';t.style.opacity='1'},100);setTimeout(function(){t.style.transform='translateX(120%)';t.style.opacity='0'},4000);setTimeout(function(){t.remove()},4600)}
  });
</script>
@endif

<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="dash-container">
    <h1 style="color:#fff;margin-bottom:4px">Welcome back, {{ Auth::user()->name }} ðŸ‘‹</h1>
    <p style="color:rgba(255,255,255,.7)">Here's your health overview for today.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="dash-container">

        <div class="dash-stats" style="margin-bottom:22px">
          <div class="dash-stat-card active" data-tab="appointments" onclick="switchTab('appointments')">
            <div class="dash-stat-icon green">ðŸ“…</div>
            <div>
              <div class="dash-stat-value">{{ $appointments->where('status', '!=', 'cancelled')->count() }}</div>
              <div class="dash-stat-label">Upcoming Appointments</div>
            </div>
          </div>
          <div class="dash-stat-card" data-tab="prescriptions" onclick="switchTab('prescriptions')">
            <div class="dash-stat-icon blue">ðŸ’Š</div>
            <div>
              <div class="dash-stat-value">{{ $prescriptions->count() }}</div>
              <div class="dash-stat-label">Active Prescriptions</div>
            </div>
          </div>
          <div class="dash-stat-card" data-tab="records" onclick="switchTab('records')">
            <div class="dash-stat-icon amber">ðŸ“‹</div>
            <div>
              <div class="dash-stat-value">{{ $medicalRecords->count() }}</div>
              <div class="dash-stat-label">Medical Records</div>
            </div>
          </div>
          <div class="dash-stat-card" data-tab="messages" onclick="switchTab('messages')">
            <div class="dash-stat-icon pink">ðŸ’¬</div>
            <div>
              <div class="dash-stat-value">{{ $unreadMessages->count() }}</div>
              <div class="dash-stat-label">Unread Messages</div>
            </div>
          </div>
        </div>

        <div class="dash-grid">
          <div>
            <div class="dash-card">
              <h4 style="margin-bottom:18px;color:#18243a">Quick Actions</h4>
              <div class="dash-actions">
                <a href="{{ route('home') }}#appointment" class="dash-action" style="background:linear-gradient(135deg,#E8F7F3,#d1ede6)">
                  <strong>ðŸ“… Book Appointment</strong>
                  <p>Schedule a visit with a doctor</p>
                </a>
                <a href="{{ route('home') }}#our_doctor" class="dash-action" style="background:linear-gradient(135deg,#EEF2FF,#dde4f7)">
                  <strong>ðŸ‘¨â€âš•ï¸ Find a Doctor</strong>
                  <p>Browse our specialists</p>
                </a>
                <a href="{{ route('patient.chat') }}" class="dash-action" style="background:linear-gradient(135deg,#FFF5EE,#fce4d6)">
                  <strong>ðŸ’¬ Chat with Doctor</strong>
                  <p>Get quick medical advice</p>
                </a>
                <a href="{{ route('patient.records') }}" class="dash-action" style="background:linear-gradient(135deg,#f0fdf4,#bbf7d0)">
                  <strong>ðŸ“‹ My Records</strong>
                  <p>View medical history &amp; reports</p>
                </a>
                <a href="{{ route('patient.lab-test') }}" class="dash-action" style="background:linear-gradient(135deg,#fdf4ff,#f0d9ff)">
                  <strong>ðŸ”¬ Do Lab Test</strong>
                  <p>Book a lab test online</p>
                </a>
                <a href="{{ route('patient.lab-results') }}" class="dash-action" style="background:linear-gradient(135deg,#eff6ff,#dbeafe)">
                  <strong>ðŸ“„ Get Result Online</strong>
                  <p>View your lab test results</p>
                </a>
              </div>
            </div>

            <div class="dash-card dash-tab-panel" id="tab-appointments" style="margin-top:20px">
              <h4 style="margin-bottom:14px;color:#18243a">Upcoming Appointments</h4>
              @if($appointments->isEmpty())
              <div class="dash-empty">
                <div style="font-size:40px;margin-bottom:8px">ðŸ“…</div>
                No upcoming appointments.<br>
                <a href="{{ route('home') }}#appointment" style="color:#1a8a6e;font-weight:600;margin-top:8px;display:inline-block">Book one now â†’</a>
              </div>
              @else
              <div style="display:flex;flex-direction:column;gap:12px">
                @foreach($appointments as $appt)
                <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
                  <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;{{ $appt->status === 'confirmed' ? 'background:#e8f7f3;' : ($appt->status === 'cancelled' ? 'background:#fef2f2;' : 'background:#fff7ed;') }}">
                    {{ $appt->status === 'confirmed' ? 'âœ…' : ($appt->status === 'cancelled' ? 'âŒ' : 'â³') }}
                  </div>
                  <div style="flex:1;min-width:0">
                    <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $appt->department }}</div>
                    <div style="font-size:.8rem;color:#8898b0">{{ $appt->date->format('d M Y') }}{{ $appt->time ? ' â€” '.$appt->time : '' }}{{ $appt->doctor ? ' â€¢ '.$appt->doctor : '' }}</div>
                  </div>
                  <span style="font-size:.75rem;font-weight:600;padding:4px 10px;border-radius:20px;text-transform:capitalize;{{ $appt->status === 'confirmed' ? 'background:#e8f7f3;color:#1a8a6e' : ($appt->status === 'cancelled' ? 'background:#fef2f2;color:#dc2626' : 'background:#fff7ed;color:#d97706') }}">{{ $appt->status }}</span>
                </div>
                @endforeach
              </div>
              @endif
            </div>

            <div class="dash-card dash-tab-panel" id="tab-prescriptions" style="margin-top:20px;display:none">
              <h4 style="margin-bottom:14px;color:#18243a">Active Prescriptions</h4>
              @if($prescriptions->isEmpty())
              <div class="dash-empty">
                <div style="font-size:40px;margin-bottom:8px">ðŸ’Š</div>
                No active prescriptions.
              </div>
              @else
              <div style="display:flex;flex-direction:column;gap:12px">
                @foreach($prescriptions as $rx)
                <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
                  <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#eef2ff">ðŸ’Š</div>
                  <div style="flex:1;min-width:0">
                    <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $rx->medication }}</div>
                    <div style="font-size:.8rem;color:#8898b0">{{ $rx->dosage }} â€” {{ $rx->frequency }}</div>
                    <div style="font-size:.75rem;color:#8898b0">Dr. {{ $rx->doctor_name }} â€¢ {{ $rx->start_date->format('d M Y') }}{{ $rx->end_date ? ' to '.$rx->end_date->format('d M Y') : '' }}</div>
                  </div>
                  <span style="font-size:.75rem;font-weight:600;padding:4px 10px;border-radius:20px;background:#e8f7f3;color:#1a8a6e">Active</span>
                </div>
                @endforeach
              </div>
              @endif
            </div>

            <div class="dash-card dash-tab-panel" id="tab-records" style="margin-top:20px;display:none">
              <h4 style="margin-bottom:14px;color:#18243a">Medical Records</h4>
              @if($medicalRecords->isEmpty())
              <div class="dash-empty">
                <div style="font-size:40px;margin-bottom:8px">ðŸ“‹</div>
                No medical records found.
              </div>
              @else
              <div style="display:flex;flex-direction:column;gap:12px">
                @foreach($medicalRecords as $record)
                <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
                  <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#fff7ed">ðŸ“‹</div>
                  <div style="flex:1;min-width:0">
                    <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $record->title }}</div>
                    <div style="font-size:.8rem;color:#8898b0">{{ ucfirst($record->type) }} â€¢ {{ $record->department }}</div>
                    <div style="font-size:.75rem;color:#8898b0">Dr. {{ $record->doctor_name }} â€¢ {{ $record->record_date->format('d M Y') }}</div>
                  </div>
                </div>
                @endforeach
              </div>
              @endif
            </div>

            <div class="dash-card dash-tab-panel" id="tab-messages" style="margin-top:20px;display:none">
              <h4 style="margin-bottom:14px;color:#18243a">Unread Messages</h4>
              @if($unreadMessages->isEmpty())
              <div class="dash-empty">
                <div style="font-size:40px;margin-bottom:8px">ðŸ’¬</div>
                No unread messages.
              </div>
              @else
              <div style="display:flex;flex-direction:column;gap:12px">
                @foreach($unreadMessages as $msg)
                <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
                  <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#fdf2f8">ðŸ’¬</div>
                  <div style="flex:1;min-width:0">
                    <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $msg->subject }}</div>
                    <div style="font-size:.8rem;color:#8898b0">{{ Str::limit($msg->body, 80) }}</div>
                    <div style="font-size:.75rem;color:#8898b0">{{ $msg->created_at->diffForHumans() }}</div>
                  </div>
                  <span style="width:10px;height:10px;border-radius:50%;background:#ec4899;flex-shrink:0" title="Unread"></span>
                </div>
                @endforeach
              </div>
              @endif
            </div>

          </div>

          <div>
            <div class="dash-card" style="text-align:center">
              <div class="dash-profile-avatar" style="background:linear-gradient(135deg,#1A8A6E,#12705A)">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <h5 style="margin-bottom:4px;color:#18243a;text-transform:none;letter-spacing:0;font-size:1.05rem">{{ Auth::user()->name }}</h5>
              <p class="text-grey" style="font-size:14px;margin-bottom:2px">{{ Auth::user()->email }}</p>
              <p style="font-size:12px;margin-bottom:18px;color:#1a8a6e;font-weight:600">Patient</p>
              <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="border-radius:8px;width:100%;justify-content:center;padding:10px 0;font-size:.9rem">Edit Profile</a>
              <form method="POST" action="{{ route('logout') }}" style="margin-top:10px">
                @csrf
                <button type="submit" class="btn" style="border-radius:8px;background:#f3f4f6;color:#6b7280;border:none;padding:10px 0;width:100%;font-size:.9rem">Log Out</button>
              </form>
            </div>

            <div class="dash-card" style="margin-top:20px;background:linear-gradient(135deg,#e8f7f3,#d1ede6);border:none">
              <div style="font-size:28px;margin-bottom:8px">ðŸ’¡</div>
              <h5 style="color:#12705a;margin-bottom:6px;text-transform:none;letter-spacing:0;font-size:.95rem">Health Tip of the Day</h5>
              <p style="font-size:.85rem;color:#526078;line-height:1.6;margin:0">Staying hydrated helps your body maintain energy, aids digestion, and supports healthy skin. Aim for 8 glasses of water daily.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function switchTab(tab) {
  document.querySelectorAll('.dash-tab-panel').forEach(function(p) { p.style.display = 'none'; });
  document.querySelectorAll('.dash-stat-card').forEach(function(c) { c.classList.remove('active'); });
  document.getElementById('tab-' + tab).style.display = 'block';
  document.querySelector('[data-tab="' + tab + '"]').classList.add('active');
}
</script>
@endsection



