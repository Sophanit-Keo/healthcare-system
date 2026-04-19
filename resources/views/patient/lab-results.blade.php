@extends('layout.main')

@push('style')
<style>
  .page-container { width:100%; max-width:1400px; margin:auto; padding:0 24px; }
  .page-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:28px; margin-bottom:20px; }
  .empty-state { text-align:center; padding:40px 16px; color:#8898b0; font-size:.9rem; }
  .status-badge { font-size:.75rem; font-weight:600; padding:4px 10px; border-radius:20px; text-transform:capitalize; }
  @media(max-width:600px){ .page-container{padding:0 14px} }
</style>
@endpush

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">ðŸ“„ Lab Results</h1>
    <p style="color:rgba(255,255,255,.7)">View your completed lab test results online.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        
        <div class="page-card">
          <h4 style="margin-bottom:14px;color:#18243a">Completed Results ({{ $results->count() }})</h4>
          @if($results->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">ðŸ“„</div>
            No completed results yet.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($results as $test)
            <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
              <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#e8f7f3">âœ…</div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $test->test_name }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $test->department }} â€¢ {{ $test->test_date->format('d M Y') }}{{ $test->doctor_name ? ' â€¢ Dr. '.$test->doctor_name : '' }}</div>
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
          <h4 style="margin-bottom:14px;color:#18243a">Pending / In Progress ({{ $pending->count() }})</h4>
          @if($pending->isEmpty())
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">â³</div>
            No pending tests.
          </div>
          @else
          <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($pending as $test)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;background:#f7f9fc;border-radius:10px">
              <div style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:{{ $test->status === 'in_progress' ? '#eef2ff' : '#fff7ed' }}">
                {{ $test->status === 'in_progress' ? 'ðŸ”„' : 'â³' }}
              </div>
              <div style="flex:1;min-width:0">
                <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $test->test_name }}</div>
                <div style="font-size:.8rem;color:#8898b0">{{ $test->department }} â€¢ {{ $test->test_date->format('d M Y') }}</div>
              </div>
              <span class="status-badge" style="{{ $test->status === 'in_progress' ? 'background:#eef2ff;color:#3b82f6' : 'background:#fff7ed;color:#d97706' }}">{{ str_replace('_', ' ', $test->status) }}</span>
            </div>
            @endforeach
          </div>
          @endif
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">â† Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection



