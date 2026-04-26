@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">Lab Order #{{ $order->id }}</h1>
    <p style="color:rgba(255,255,255,.7)">Order status, notes, and items.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card" style="max-width:1000px;margin-left:auto;margin-right:auto">
          <div class="form-grid">
            <div>
              <div class="soft-muted">Status</div>
              <div style="margin-top:2px"><span class="soft-badge">{{ str_replace('_', ' ', (string) $order->status) }}</span></div>
            </div>
            <div>
              <div class="soft-muted">Ordered at</div>
              <div style="font-weight:600">{{ $order->ordered_at ?? $order->created_at }}</div>
            </div>
          </div>

          @if ($order->notes)
            <div style="margin-top:14px">
              <div class="soft-muted">Notes</div>
              <div style="white-space:pre-line">{{ $order->notes }}</div>
            </div>
          @endif
        </div>

        <div class="page-card" style="max-width:1000px;margin-left:auto;margin-right:auto">
          <h4>Items</h4>
          <div class="soft-table-wrap">
            <table class="soft-table">
              <thead>
                <tr>
                  <th>Test</th>
                  <th>Specimen</th>
                  <th>Status</th>
                  <th>Result</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->items as $item)
                  <tr>
                    <td>{{ $item->test_name }}</td>
                    <td>{{ $item->specimen ?? '-' }}</td>
                    <td><span class="soft-badge">{{ str_replace('_', ' ', (string) $item->status) }}</span></td>
                    <td style="white-space:pre-line">{{ $item->result ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('patient.lab-orders.index') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

