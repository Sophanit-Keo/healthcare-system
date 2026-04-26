@extends('layout.main')
@include('patient.partials.ui')

@push('style')
<style>
  .empty-state { text-align:center; padding:40px 16px; color:#8898b0; font-size:.9rem; }
  .status-badge { font-size:.75rem; font-weight:600; padding:4px 10px; border-radius:20px; text-transform:capitalize; }
  @media(max-width:600px){ .page-container{padding:0 14px} }
</style>
@endpush

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">&#128196; Lab Results</h1>
    <p class="page-hero-subtitle">View your completed lab test results online.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
      <div class="page-container">

        
        <div class="page-card">
          <h4>Completed Results ({{ $results->count() }})</h4>
          @if($results->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">&#128196;</div>
            No completed results yet.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($results as $test)
            <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
              <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#e8f7f3">&#9989;</div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $test->test_name }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $test->department }} &bull; {{ $test->test_date->format('d M Y') }}{{ $test->doctor_name ? ' &bull; Dr. '.$test->doctor_name : '' }}</div>
                @if($test->result)
                <div style="margin-top:8px;padding:10px 14px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#18243a">
                  <strong style="color:#1a8a6e">Result:</strong> {{ $test->result }}
                </div>
                @endif
                @if($test->notes)
                <div style="font-size:.8rem;color:#526078;margin-top:4px">{{ $test->notes }}</div>
                @endif
              </div>
              <span class="status-badge" style="background:#e8f7f3;color:#1a8a6e">Completed</span>
            </div>
            @endforeach
          </div>
          @endif
        </div>

        
        <div class="page-card">
          <h4>Pending / In Progress ({{ $pending->count() }})</h4>
          @if($pending->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">&#9203;</div>
            No pending tests.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($pending as $test)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
              <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:{{ $test->status === 'in_progress' ? '#eef2ff' : '#fff7ed' }}">
                @if ($test->status === 'in_progress')
                  <span aria-hidden="true">&#128260;</span>
                @else
                  <span aria-hidden="true">&#9203;</span>
                @endif
              </div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $test->test_name }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $test->department }} &bull; {{ $test->test_date->format('d M Y') }}</div>
              </div>
              <span class="status-badge" style="{{ $test->status === 'in_progress' ? 'background:#eef2ff;color:#3b82f6' : 'background:#fff7ed;color:#d97706' }}">{{ str_replace('_', ' ', $test->status) }}</span>
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


