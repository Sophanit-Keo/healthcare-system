@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">My Lab Orders</h1>
    <p style="color:rgba(255,255,255,.7)">Track orders and view the items and results.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card">
          <div class="soft-table-wrap">
            <table class="soft-table">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Status</th>
                  <th>Ordered at</th>
                  <th style="text-align:right">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($orders as $order)
                  <tr>
                    <td>#{{ $order->id }}</td>
                    <td><span class="soft-badge">{{ str_replace('_', ' ', (string) $order->status) }}</span></td>
                    <td>{{ $order->ordered_at ?? $order->created_at }}</td>
                    <td style="text-align:right"><a href="{{ route('patient.lab-orders.show', $order) }}" style="color:#1a8a6e;font-weight:600">View</a></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="soft-muted" style="text-align:center;padding:26px">No lab orders yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div style="margin-top:14px">{{ $orders->links() }}</div>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

