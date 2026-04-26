@extends('layout.main')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a2a5e 100%);padding:50px 0 34px">
  <div class="container" style="display:flex;align-items:end;justify-content:space-between;gap:16px;flex-wrap:wrap">
    <div>
      <h1 style="color:#fff;margin-bottom:4px">My Prescriptions</h1>
      <p style="color:rgba(255,255,255,.7)">Create and manage prescriptions for your patients.</p>
    </div>
    <a href="{{ route('doctor.prescriptions.create') }}" class="btn btn-primary" style="border-radius:10px">New Prescription</a>
  </div>
</div>

<div class="page-section">
  <div class="container">
    @if(session('success'))
      <div style="max-width:900px;margin:0 auto 18px;padding:12px 16px;background:#e8f7f3;color:#12705a;border-radius:10px;font-weight:500">
        {{ session('success') }}
      </div>
    @endif

    <div style="background:#fff;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden">
      <div style="overflow:auto">
        <table class="table table-hover" style="margin:0;min-width:900px">
          <thead style="background:#f8fafc">
            <tr>
              <th style="padding:14px 16px">Patient</th>
              <th style="padding:14px 16px">Medication</th>
              <th style="padding:14px 16px">Dosage</th>
              <th style="padding:14px 16px">Frequency</th>
              <th style="padding:14px 16px">Start</th>
              <th style="padding:14px 16px">End</th>
              <th style="padding:14px 16px">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($prescriptions as $rx)
              <tr>
                <td style="padding:14px 16px;font-weight:600">{{ $rx->user->name ?? ('User #' . $rx->user_id) }}</td>
                <td style="padding:14px 16px">{{ $rx->medication }}</td>
                <td style="padding:14px 16px;color:#6b7280">{{ $rx->dosage ?? '-' }}</td>
                <td style="padding:14px 16px;color:#6b7280">{{ $rx->frequency ?? '-' }}</td>
                <td style="padding:14px 16px;color:#6b7280">{{ $rx->start_date?->format('Y-m-d') ?? '-' }}</td>
                <td style="padding:14px 16px;color:#6b7280">{{ $rx->end_date?->format('Y-m-d') ?? '-' }}</td>
                <td style="padding:14px 16px">
                  <span class="badge badge-green">{{ ucfirst($rx->status ?? 'active') }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" style="padding:22px 16px;color:#6b7280;text-align:center">No prescriptions yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div style="padding:14px 16px">
        {{ $prescriptions->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

