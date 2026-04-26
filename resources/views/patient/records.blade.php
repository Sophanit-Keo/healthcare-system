@extends('layout.main')
@include('patient.partials.ui')

@push('style')
<style>
  .record-item { display:flex; align-items:center; gap:14px; padding:14px 18px; background:#f7f9fc; border-radius:10px; }
  .record-icon { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
  .empty-state { text-align:center; padding:40px 16px; color:#8898b0; font-size:.9rem; }
  .type-badge { font-size:.75rem; font-weight:600; padding:4px 10px; border-radius:20px; text-transform:capitalize; }
  @media(max-width:600px){ .page-container{padding:0 14px} }
</style>
@endpush

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">&#128203; My Medical Records</h1>
    <p class="page-hero-subtitle">View your complete medical history and reports.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
      <div class="page-container">

        <div class="page-card">
          <h4>All Records ({{ $records->count() }})</h4>
          @if($records->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">&#128203;</div>
            No medical records found.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($records as $record)
            <div class="record-item">
              <div class="record-icon" style="background:{{ $record->type === 'lab' ? '#eef2ff' : ($record->type === 'imaging' ? '#fdf2f8' : ($record->type === 'surgery' ? '#fef2f2' : '#fff7ed')) }}">
                @switch($record->type)
                  @case('lab')
                    <span aria-hidden="true">&#129514;</span>
                    @break
                  @case('imaging')
                    <span aria-hidden="true">&#128247;</span>
                    @break
                  @case('surgery')
                    <span aria-hidden="true">&#127973;</span>
                    @break
                  @case('checkup')
                    <span aria-hidden="true">&#128137;</span>
                    @break
                  @default
                    <span aria-hidden="true">&#128196;</span>
                @endswitch
              </div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $record->title }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $record->department }} &bull; Dr. {{ $record->doctor_name }}</div>
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

        <div class="mt-2">
          <a href="{{ route('dashboard') }}" class="link-soft-primary back-link">&larr; Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection


