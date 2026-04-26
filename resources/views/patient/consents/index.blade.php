@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">Facility Consents</h1>
    <p style="color:rgba(255,255,255,.7)">Grant or revoke consent for facilities to access your information.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        @if (session('status'))
          <div class="alert-success">{{ session('status') }}</div>
        @endif

        <div class="page-card">
          <h4>Grant consent</h4>
          <form method="POST" action="{{ route('patient.consents.store') }}">
            @csrf
            <div class="form-grid" style="margin-bottom:14px">
              <div>
                <label class="form-label">Facility</label>
                <select name="facility_id" required class="form-select">
                  <option value="">Select a facility</option>
                  @foreach ($facilities as $facility)
                    <option value="{{ $facility->id }}" @selected(old('facility_id') == $facility->id)>{{ $facility->name }}</option>
                  @endforeach
                </select>
                @error('facility_id')<div class="form-error">{{ $message }}</div>@enderror
              </div>
              <div>
                <label class="form-label">Expires at (optional)</label>
                <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="form-input">
                @error('expires_at')<div class="form-error">{{ $message }}</div>@enderror
              </div>
            </div>
            <button type="submit" class="btn-soft-primary">Grant consent</button>
          </form>
        </div>

        <div class="page-card">
          <h4>My consents</h4>
          <div class="soft-table-wrap">
            <table class="soft-table">
              <thead>
                <tr>
                  <th>Facility</th>
                  <th>Status</th>
                  <th>Granted</th>
                  <th>Expires</th>
                  <th style="text-align:right">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($consents as $consent)
                  <tr>
                    <td>{{ $consent->facility?->name ?? ('Facility #' . $consent->facility_id) }}</td>
                    <td>
                      @php($status = (string) ($consent->status ?? 'granted'))
                      <span class="soft-badge {{ $status === 'granted' ? 'green' : 'amber' }}">{{ str_replace('_', ' ', $status) }}</span>
                    </td>
                    <td>{{ $consent->granted_at ?? '-' }}</td>
                    <td>{{ $consent->expires_at ?? '-' }}</td>
                    <td style="text-align:right">
                      @if ($consent->status === 'granted')
                        <form method="POST" action="{{ route('patient.consents.destroy', $consent) }}" style="display:inline" onsubmit="return confirm('Revoke consent?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn-soft-ghost" style="background:#fef2f2;color:#b91c1c" type="submit">Revoke</button>
                        </form>
                      @else
                        <span class="soft-muted">-</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="soft-muted" style="text-align:center;padding:26px">No consents yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div style="margin-top:14px">{{ $consents->links() }}</div>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

