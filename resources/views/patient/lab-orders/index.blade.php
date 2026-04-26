@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">My Lab Orders</h1>
    <p class="page-hero-subtitle">Track orders and view the items and results.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
      <div class="page-container">

        <div class="page-card">
          <div class="soft-table-wrap">
            <table class="soft-table">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Status</th>
                  <th>Ordered at</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($orders as $order)
                  <tr>
                    <td>#{{ $order->id }}</td>
                    <td>@include('patient.partials.status-badge', ['status' => $order->status])</td>
                    <td>{{ $order->ordered_at ?? $order->created_at }}</td>
                    <td class="text-end"><a href="{{ route('patient.lab-orders.show', $order) }}" class="link-soft-primary">View</a></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="soft-muted soft-empty">No lab orders yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
        </div>

        <div class="mt-2">
          <a href="{{ route('dashboard') }}" class="link-soft-primary back-link">&larr; Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
