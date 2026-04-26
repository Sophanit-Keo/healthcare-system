@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">My Encounters</h1>
    <p style="color:rgba(255,255,255,.7)">Review encounter notes, diagnosis, and vitals.</p>
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
                  <th>Type</th>
                  <th>Started</th>
                  <th>Ended</th>
                  <th>Diagnosis</th>
                  <th style="text-align:right">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($encounters as $encounter)
                  <tr>
                    <td>{{ $encounter->encounter_type }}</td>
                    <td>{{ $encounter->started_at }}</td>
                    <td>{{ $encounter->ended_at ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit((string) $encounter->diagnosis, 60) }}</td>
                    <td style="text-align:right">
                      <a href="{{ route('patient.encounters.show', $encounter) }}" style="color:#1a8a6e;font-weight:600">View</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="soft-muted" style="text-align:center;padding:26px">No encounters yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div style="margin-top:14px">{{ $encounters->links() }}</div>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

