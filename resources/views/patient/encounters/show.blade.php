@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">Encounter #{{ $encounter->id }}</h1>
    <p style="color:rgba(255,255,255,.7)">Details, vital signs, and related lab orders.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card" style="max-width:1000px;margin-left:auto;margin-right:auto">
          <div class="form-grid" style="margin-bottom:8px">
            <div>
              <div class="soft-muted">Type</div>
              <div style="font-weight:600">{{ $encounter->encounter_type }}</div>
            </div>
            <div>
              <div class="soft-muted">Started</div>
              <div style="font-weight:600">{{ $encounter->started_at ?? '-' }}</div>
            </div>
            <div>
              <div class="soft-muted">Ended</div>
              <div style="font-weight:600">{{ $encounter->ended_at ?? '-' }}</div>
            </div>
          </div>

          @if ($encounter->chief_complaint)
            <div style="margin-top:12px">
              <div class="soft-muted">Chief complaint</div>
              <div style="white-space:pre-line">{{ $encounter->chief_complaint }}</div>
            </div>
          @endif

          @if ($encounter->diagnosis)
            <div style="margin-top:12px">
              <div class="soft-muted">Diagnosis</div>
              <div style="white-space:pre-line">{{ $encounter->diagnosis }}</div>
            </div>
          @endif

          @if ($encounter->treatment_plan)
            <div style="margin-top:12px">
              <div class="soft-muted">Treatment plan</div>
              <div style="white-space:pre-line">{{ $encounter->treatment_plan }}</div>
            </div>
          @endif

          @if ($encounter->notes)
            <div style="margin-top:12px">
              <div class="soft-muted">Notes</div>
              <div style="white-space:pre-line">{{ $encounter->notes }}</div>
            </div>
          @endif
        </div>

        <div class="page-card" style="max-width:1000px;margin-left:auto;margin-right:auto">
          <h4>Vital signs</h4>
          <div class="soft-table-wrap">
            <table class="soft-table">
              <thead>
                <tr>
                  <th>Recorded</th>
                  <th>Temp</th>
                  <th>BP</th>
                  <th>HR</th>
                  <th>SpO2</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($encounter->vitalSigns as $vs)
                  <tr>
                    <td>{{ $vs->recorded_at ?? $vs->created_at }}</td>
                    <td>{{ $vs->temperature ?? '-' }}</td>
                    <td>
                      @if ($vs->blood_pressure_systolic && $vs->blood_pressure_diastolic)
                        {{ $vs->blood_pressure_systolic }}/{{ $vs->blood_pressure_diastolic }}
                      @else
                        -
                      @endif
                    </td>
                    <td>{{ $vs->heart_rate ?? '-' }}</td>
                    <td>{{ $vs->oxygen_saturation ?? '-' }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="soft-muted" style="text-align:center;padding:26px">No vital signs recorded.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="page-card" style="max-width:1000px;margin-left:auto;margin-right:auto">
          <h4>Lab orders</h4>
          <div style="display:flex;flex-direction:column;gap:12px">
            @forelse ($encounter->labOrders as $order)
              <div style="padding:14px 16px;background:#f7f9fc;border-radius:12px;border:1px solid #eef2f7">
                <div class="actions-row" style="justify-content:space-between">
                  <div style="font-weight:700;color:#18243a">Order #{{ $order->id }}</div>
                  <span class="soft-badge">{{ str_replace('_', ' ', (string) $order->status) }}</span>
                </div>
                <div style="margin-top:10px">
                  <div class="soft-muted">Items</div>
                  <ul style="margin:6px 0 0 18px;color:#18243a;font-size:.9rem">
                    @foreach ($order->items as $item)
                      <li>{{ $item->test_name }} ({{ $item->status }})</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            @empty
              <div class="soft-muted">No lab orders linked to this encounter.</div>
            @endforelse
          </div>
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('patient.encounters.index') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

