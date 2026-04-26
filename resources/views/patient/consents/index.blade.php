@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">Facility Consents</h1>
    <p class="page-hero-subtitle">Grant or revoke consent for facilities to access your information.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section page-section--flush">
    <div class="page-float">
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
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($consents as $consent)
                  <tr>
                    <td>{{ $consent->facility?->name ?? ('Facility #' . $consent->facility_id) }}</td>
                    <td>
                      @include('patient.partials.status-badge', ['status' => $consent->status ?? 'granted'])
                    </td>
                    <td>{{ $consent->granted_at ?? '-' }}</td>
                    <td>{{ $consent->expires_at ?? '-' }}</td>
                    <td class="text-end">
                      @if ($consent->status === 'granted')
                        <form method="POST" action="{{ route('patient.consents.destroy', $consent) }}" style="display:inline" onsubmit="return confirm('Revoke consent?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn-soft-danger" type="submit">Revoke</button>
                        </form>
                      @else
                        <span class="soft-muted">-</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="soft-muted soft-empty">No consents yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">{{ $consents->links('pagination::bootstrap-5') }}</div>
        </div>

        <div class="mt-2">
          <a href="{{ route('dashboard') }}" class="link-soft-primary back-link">&larr; Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
