@extends('layout.main')
@include('patient.partials.ui')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">Welcome, {{ Auth::user()->name }}</h1>
    <p style="color:rgba(255,255,255,.7)">Your health summary and quick actions.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="row mb-4" style="align-items:stretch">
          <div class="col-md-3 py-2">
            <div class="card-service" style="text-align:center;padding:26px 16px;height:100%">
              <div class="circle-shape bg-primary text-white" style="font-size:26px">📅</div>
              <h5 style="margin-top:12px;margin-bottom:4px">Appointments</h5>
              <p class="text-grey mb-0">{{ $appointmentsCount ?? 0 }}</p>
            </div>
          </div>
          <div class="col-md-3 py-2">
            <div class="card-service" style="text-align:center;padding:26px 16px;height:100%">
              <div class="circle-shape bg-secondary text-white" style="font-size:26px">🩺</div>
              <h5 style="margin-top:12px;margin-bottom:4px">Encounters</h5>
              <p class="text-grey mb-0">{{ $encountersCount ?? 0 }}</p>
            </div>
          </div>
          <div class="col-md-3 py-2">
            <div class="card-service" style="text-align:center;padding:26px 16px;height:100%">
              <div class="circle-shape bg-accent text-white" style="font-size:26px">🧪</div>
              <h5 style="margin-top:12px;margin-bottom:4px">Lab Orders</h5>
              <p class="text-grey mb-0">{{ $labOrdersCount ?? 0 }}</p>
            </div>
          </div>
          <div class="col-md-3 py-2">
            <div class="card-service" style="text-align:center;padding:26px 16px;height:100%">
              <div class="circle-shape bg-primary text-white" style="font-size:26px">✅</div>
              <h5 style="margin-top:12px;margin-bottom:4px">Consents</h5>
              <p class="text-grey mb-0">{{ $consentsCount ?? 0 }}</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 py-2">
            <div class="page-card">
              <h4 style="margin-bottom:20px">Quick Actions</h4>
              <div class="row">
                <div class="col-sm-6 mb-3">
                  <a href="{{ route('patient.appointments.index') }}" style="display:block;padding:18px;background:linear-gradient(135deg,#EEF2FF,#dde4f7);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">📅 My Appointments</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">View or request appointments</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="{{ route('patient.encounters.index') }}" style="display:block;padding:18px;background:linear-gradient(135deg,#f0fdf4,#bbf7d0);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">🩺 My Encounters</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Review encounter details</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="{{ route('patient.lab-orders.index') }}" style="display:block;padding:18px;background:linear-gradient(135deg,#FFF5EE,#fce4d6);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">🧪 Lab Orders</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Track lab orders and items</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="{{ route('patient.consents.index') }}" style="display:block;padding:18px;background:linear-gradient(135deg,#E8F7F3,#d1ede6);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">✅ Consents</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Grant or revoke facility consent</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="{{ route('patient.records') }}" style="display:block;padding:18px;background:linear-gradient(135deg,#FDF2F8,#fbcfe8);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">📋 Medical Records</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">View your records</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="{{ route('patient.chat') }}" style="display:block;padding:18px;background:linear-gradient(135deg,#EFF6FF,#bfdbfe);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">💬 Messages</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Chat with your doctors</p>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 py-2">
            <div class="page-card" style="text-align:center">
              <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#1a8a6e,#12705a);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:32px;color:#fff">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <h5 style="margin-bottom:4px;color:#18243a">{{ Auth::user()->name }}</h5>
              <p class="text-grey" style="font-size:14px;margin-bottom:4px">{{ Auth::user()->email }}</p>
              <p class="text-grey" style="font-size:13px;margin-bottom:16px">Patient</p>
              <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm" style="border-radius:8px">Edit Profile</a>
              <form method="POST" action="{{ route('logout') }}" style="margin-top:10px">
                @csrf
                <button type="submit" class="btn btn-sm" style="border-radius:8px;background:#f3f4f6;color:#6b7280;border:none;padding:6px 20px">Log Out</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
