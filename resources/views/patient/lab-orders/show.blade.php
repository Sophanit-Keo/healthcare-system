@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">Lab Order #{{ $order->id }}</h1>
    <p class="page-hero-subtitle">Order status, notes, and items.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
      <div class="page-container">

        <div class="page-card page-card--wide">
          <div class="form-grid">
            <div>
              <div class="soft-muted">Status</div>
              <div style="margin-top:2px">@include('patient.partials.status-badge', ['status' => $order->status])</div>
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

        <div class="page-card page-card--wide">
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
                    <td>@include('patient.partials.status-badge', ['status' => $item->status])</td>
                    <td class="pre-line">{{ $item->result ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-2">
          <a href="{{ route('patient.lab-orders.index') }}" class="link-soft-primary back-link">&larr; Back</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
