@extends('layout.main')

@push('style')
<style>
  .page-container { width:100%; max-width:1400px; margin:auto; padding:0 24px; }
  .page-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:28px; margin-bottom:20px; }
  .lab-form select, .lab-form input, .lab-form textarea { width:100%; border:1px solid #e2e8f0; border-radius:10px; padding:10px 12px; font-size:.9rem; }
  .lab-form textarea { resize:vertical; min-height:70px; }
  .lab-form label { font-weight:600; font-size:.85rem; color:#18243a; margin-bottom:6px; display:block; }
  .btn-book { background:linear-gradient(135deg,#1a8a6e,#12705a); color:#fff; border:none; padding:12px 32px; border-radius:10px; font-weight:600; font-size:.9rem; cursor:pointer; }
  .btn-book:hover { opacity:.9; }
  .empty-state { text-align:center; padding:40px 16px; color:#8898b0; font-size:.9rem; }
  .status-badge { font-size:.75rem; font-weight:600; padding:4px 10px; border-radius:20px; text-transform:capitalize; }
  @media(max-width:600px){ .page-container{padding:0 14px} .lab-form .grid-2{grid-template-columns:1fr!important} }
</style>
@endpush

@section('content')
@if(session('success'))
<div id="toast" style="position:fixed;top:30px;right:30px;z-index:9999;min-width:320px;max-width:420px;padding:18px 24px;border-radius:12px;color:#fff;font-weight:500;font-size:.95rem;box-shadow:0 8px 32px rgba(0,0,0,.18);display:flex;align-items:center;gap:12px;transform:translateX(120%);transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .4s;opacity:0;background:linear-gradient(135deg,#1a8a6e,#12705a)">
  <span style="font-size:22px">✅</span><span>{{ session('success') }}</span>
</div>
<script>document.addEventListener('DOMContentLoaded',function(){var t=document.getElementById('toast');if(t){setTimeout(function(){t.style.transform='translateX(0)';t.style.opacity='1'},100);setTimeout(function(){t.style.transform='translateX(120%)';t.style.opacity='0'},4000)}});</script>
@endif

<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">🔬 Book a Lab Test</h1>
    <p style="color:rgba(255,255,255,.7)">Request a lab test and get your results online.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        
        <div class="page-card">
          <h4 style="margin-bottom:18px;color:#18243a">Request Lab Test</h4>
          <form method="POST" action="{{ route('patient.lab-test.book') }}" class="lab-form">
            @csrf
            <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
              <div>
                <label>Test Name</label>
                <select name="test_name" required>
                  <option value="">-- Select test --</option>
                  <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                  <option value="Blood Sugar (Glucose)">Blood Sugar (Glucose)</option>
                  <option value="Lipid Profile">Lipid Profile</option>
                  <option value="Liver Function Test">Liver Function Test</option>
                  <option value="Kidney Function Test">Kidney Function Test</option>
                  <option value="Thyroid Function Test">Thyroid Function Test</option>
                  <option value="Urine Analysis">Urine Analysis</option>
                  <option value="Vitamin D Test">Vitamin D Test</option>
                  <option value="HbA1c">HbA1c</option>
                  <option value="COVID-19 PCR">COVID-19 PCR</option>
                  <option value="X-Ray">X-Ray</option>
                  <option value="MRI Scan">MRI Scan</option>
                  <option value="CT Scan">CT Scan</option>
                  <option value="Ultrasound">Ultrasound</option>
                </select>
                @error('test_name')<span style="color:#dc2626;font-size:.8rem">{{ $message }}</span>@enderror
              </div>
              <div>
                <label>Department</label>
                <select name="department" required>
                  <option value="">-- Select department --</option>
                  <option value="Pathology">Pathology</option>
                  <option value="Radiology">Radiology</option>
                  <option value="Cardiology">Cardiology</option>
                  <option value="Endocrinology">Endocrinology</option>
                  <option value="General Medicine">General Medicine</option>
                </select>
                @error('department')<span style="color:#dc2626;font-size:.8rem">{{ $message }}</span>@enderror
              </div>
            </div>
            <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
              <div>
                <label>Preferred Date</label>
                <input type="date" name="test_date" value="{{ old('test_date') }}" min="{{ date('Y-m-d') }}" required>
                @error('test_date')<span style="color:#dc2626;font-size:.8rem">{{ $message }}</span>@enderror
              </div>
              <div>
                <label>Notes (optional)</label>
                <textarea name="notes" placeholder="Any special instructions...">{{ old('notes') }}</textarea>
              </div>
            </div>
            <button type="submit" class="btn-book">Book Lab Test</button>
          </form>
        </div>

        
        <div class="page-card">
          <h4 style="margin-bottom:14px;color:#18243a">My Lab Tests</h4>
          @if($labTests->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">🔬</div>
            No lab tests booked yet.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($labTests as $test)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
              <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#fdf4ff">🔬</div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $test->test_name }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $test->department }} • {{ $test->test_date->format('d M Y') }}</div>
              </div>
              <span class="status-badge" style="{{ $test->status === 'completed' ? 'background:#e8f7f3;color:#1a8a6e' : ($test->status === 'in_progress' ? 'background:#eef2ff;color:#3b82f6' : 'background:#fff7ed;color:#d97706') }}">{{ str_replace('_', ' ', $test->status) }}</span>
            </div>
            @endforeach
          </div>
          @endif
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection



