@extends('layout.main')

@section('content')
<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a2a5e 100%);padding:60px 0 40px">
  <div class="container">
    <h1 style="color:#fff;margin-bottom:4px">Welcome, Dr. {{ Auth::user()->name }} ðŸ‘‹</h1>
    <p style="color:rgba(255,255,255,.7)">Here's your schedule and patient overview.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="container">

        <div class="row mb-4">
          <div class="col-md-4 py-2">
            <div class="card-service" style="text-align:center;padding:28px 20px">
              <div class="circle-shape bg-secondary text-white" style="font-size:28px">ðŸ‘¥</div>
              <h5 style="margin-top:12px;margin-bottom:4px">My Patients</h5>
              <p class="text-grey mb-0">0 assigned</p>
            </div>
          </div>
          <div class="col-md-4 py-2">
            <div class="card-service" style="text-align:center;padding:28px 20px">
              <div class="circle-shape bg-primary text-white" style="font-size:28px">ðŸ“…</div>
              <h5 style="margin-top:12px;margin-bottom:4px">Today's Appointments</h5>
              <p class="text-grey mb-0">0 scheduled</p>
            </div>
          </div>
          <div class="col-md-4 py-2">
            <div class="card-service" style="text-align:center;padding:28px 20px">
              <div class="circle-shape bg-accent text-white" style="font-size:28px">ðŸ“Š</div>
              <h5 style="margin-top:12px;margin-bottom:4px">Reports</h5>
              <p class="text-grey mb-0">View analytics</p>
            </div>
          </div>
        </div>

        
        <div class="row">
          <div class="col-lg-8 py-2">
            <div style="background:#fff;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);padding:28px">
              <h4 style="margin-bottom:20px">Quick Actions</h4>
              <div class="row">
                <div class="col-sm-6 mb-3">
                  <a href="#" style="display:block;padding:18px;background:linear-gradient(135deg,#EEF2FF,#dde4f7);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">ðŸ“‹ View Patients</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Manage your patient list</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="#" style="display:block;padding:18px;background:linear-gradient(135deg,#E8F7F3,#d1ede6);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">ðŸ“… My Schedule</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">View upcoming appointments</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="#" style="display:block;padding:18px;background:linear-gradient(135deg,#f0fdf4,#bbf7d0);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">ðŸ“ Write Prescription</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Create a new prescription</p>
                  </a>
                </div>
                <div class="col-sm-6 mb-3">
                  <a href="#" style="display:block;padding:18px;background:linear-gradient(135deg,#FFF5EE,#fce4d6);border-radius:10px;text-decoration:none;color:#0d2137">
                    <strong style="font-size:16px">ðŸ’¬ Messages</strong>
                    <p class="text-grey mb-0" style="font-size:13px;margin-top:4px">Chat with patients</p>
                  </a>
                </div>
              </div>
            </div>
          </div>

          
          <div class="col-lg-4 py-2">
            <div style="background:#fff;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);padding:28px;text-align:center">
              <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#2a5ce5,#1a3a8e);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:32px;color:#fff">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <h5 style="margin-bottom:4px;color:#18243a">Dr. {{ Auth::user()->name }}</h5>
              <p class="text-grey" style="font-size:14px;margin-bottom:4px">{{ Auth::user()->email }}</p>
              <p class="text-grey" style="font-size:13px;margin-bottom:16px">Doctor</p>
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



