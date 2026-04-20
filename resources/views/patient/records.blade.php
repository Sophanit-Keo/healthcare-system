@extends('layout.main')

@push('style')
<style>
  .page-container { width:100%; max-width:1400px; margin:auto; padding:0 24px; }
  .page-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:28px; margin-bottom:20px; }
  .record-item { display:flex; align-items:center; gap:14px; padding:14px 18px; background:#f7f9fc; border-radius:10px; }
  .record-icon { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
  .empty-state { text-align:center; padding:40px 16px; color:#8898b0; font-size:.9rem; }
  .type-badge { font-size:.75rem; font-weight:600; padding:4px 10px; border-radius:20px; text-transform:capitalize; }
  @media(max-width:600px){ .page-container{padding:0 14px} }
</style>
@endpush

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">📋 My Medical Records</h1>
    <p style="color:rgba(255,255,255,.7)">View your complete medical history and reports.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card">
          <h4 style="margin-bottom:18px;color:#18243a">All Records ({{ $records->count() }})</h4>
          @if($records->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">📋</div>
            No medical records found.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($records as $record)
            <div class="record-item">
              <div class="record-icon" style="background:{{ $record->type === 'lab' ? '#eef2ff' : ($record->type === 'imaging' ? '#fdf2f8' : ($record->type === 'surgery' ? '#fef2f2' : '#fff7ed')) }}">
                {{ $record->type === 'lab' ? '🔬' : ($record->type === 'imaging' ? '🩻' : ($record->type === 'surgery' ? '🏥' : ($record->type === 'checkup' ? '🩺' : '📄'))) }}
              </div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $record->title }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $record->department }} • Dr. {{ $record->doctor_name }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $record->record_date->format('d M Y') }}</div>
                @if($record->diagnosis)
                <div style="font-size:.8rem;color:#526078;margin-top:4px"><strong>Diagnosis:</strong> {{ $record->diagnosis }}</div>
                @endif
                @if($record->description)
                <div style="font-size:.8rem;color:#526078;margin-top:2px">{{ $record->description }}</div>
                @endif
              </div>
              <span class="type-badge" style="background:{{ $record->type === 'lab' ? '#eef2ff;color:#3b82f6' : ($record->type === 'imaging' ? '#fdf2f8;color:#ec4899' : ($record->type === 'surgery' ? '#fef2f2;color:#dc2626' : '#fff7ed;color:#d97706')) }}">{{ $record->type }}</span>
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



