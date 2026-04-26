@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark patient-hero">
  <div class="page-container">
    <h1 class="page-hero-title">My Encounters</h1>
    <p class="page-hero-subtitle">Review encounter notes, diagnosis, and vitals.</p>
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
                  <th>Type</th>
                  <th>Started</th>
                  <th>Ended</th>
                  <th>Diagnosis</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($encounters as $encounter)
                  <tr>
                    <td>{{ $encounter->encounter_type }}</td>
                    <td>{{ $encounter->started_at }}</td>
                    <td>{{ $encounter->ended_at ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit((string) $encounter->diagnosis, 60) }}</td>
                    <td class="text-end">
                      <a href="{{ route('patient.encounters.show', $encounter) }}" class="link-soft-primary">View</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="soft-muted soft-empty">No encounters yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">{{ $encounters->links('pagination::bootstrap-5') }}</div>
        </div>

        <div class="mt-2">
          <a href="{{ route('dashboard') }}" class="link-soft-primary back-link">&larr; Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
