@extends('layout.main')

@push('style')
<style>
  .page-container { width:100%; max-width:1400px; margin:auto; padding:0 24px; }
  .page-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:28px; margin-bottom:20px; }
  .msg-item { display:flex; gap:14px; padding:14px 18px; background:#f7f9fc; border-radius:10px; }
  .msg-icon { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; font-weight:600; color:#fff; }
  .chat-form textarea { width:100%; border:1px solid #e2e8f0; border-radius:10px; padding:12px; font-size:.9rem; resize:vertical; min-height:80px; }
  .chat-form select, .chat-form input { width:100%; border:1px solid #e2e8f0; border-radius:10px; padding:10px 12px; font-size:.9rem; }
  .chat-form label { font-weight:600; font-size:.85rem; color:#18243a; margin-bottom:6px; display:block; }
  .btn-send { background:linear-gradient(135deg,#1a8a6e,#12705a); color:#fff; border:none; padding:12px 32px; border-radius:10px; font-weight:600; font-size:.9rem; cursor:pointer; }
  .btn-send:hover { opacity:.9; }
  .empty-state { text-align:center; padding:40px 16px; color:#8898b0; font-size:.9rem; }
  @media(max-width:600px){ .page-container{padding:0 14px} }
</style>
@endpush

@section('content')
@if(session('success'))
<div id="toast" style="position:fixed;top:30px;right:30px;z-index:9999;min-width:320px;max-width:420px;padding:18px 24px;border-radius:12px;color:#fff;font-weight:500;font-size:.95rem;box-shadow:0 8px 32px rgba(0,0,0,.18);display:flex;align-items:center;gap:12px;transform:translateX(120%);transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .4s;opacity:0;background:linear-gradient(135deg,#1a8a6e,#12705a)">
  <span style="font-size:22px">&#9989;</span><span>{{ session('success') }}</span>
</div>
<script>document.addEventListener('DOMContentLoaded',function(){var t=document.getElementById('toast');if(t){setTimeout(function(){t.style.transform='translateX(0)';t.style.opacity='1'},100);setTimeout(function(){t.style.transform='translateX(120%)';t.style.opacity='0'},4000)}});</script>
@endif

<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a2a5e 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">&#128172; Messages</h1>
    <p style="color:rgba(255,255,255,.7)">Send messages to your patients.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        <div class="page-card">
          <h4 style="margin-bottom:18px;color:#18243a">Send a Message</h4>
          <form method="POST" action="{{ route('doctor.send-message') }}" class="chat-form">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
              <div>
                <label>Select Patient</label>
                <select name="receiver_id" required>
                  <option value="">-- Choose a patient --</option>
                  @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                  @endforeach
                </select>
                @error('receiver_id')<span style="color:#dc2626;font-size:.8rem">{{ $message }}</span>@enderror
              </div>
              <div>
                <label>Subject</label>
                <input type="text" name="subject" placeholder="e.g. Follow-up" value="{{ old('subject') }}" required>
                @error('subject')<span style="color:#dc2626;font-size:.8rem">{{ $message }}</span>@enderror
              </div>
            </div>
            <div style="margin-bottom:14px">
              <label>Message</label>
              <textarea name="body" placeholder="Type your message here..." required>{{ old('body') }}</textarea>
              @error('body')<span style="color:#dc2626;font-size:.8rem">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn-send">Send Message</button>
          </form>
        </div>

        <div class="page-card">
          <h4 style="margin-bottom:14px;color:#18243a">Message History</h4>
          @if($messages->isEmpty())
            <div class="empty-state">
              <div style="font-size:40px;margin-bottom:8px">&#128172;</div>
              No messages yet. Send one to get started!
            </div>
          @else
            <div style="display:flex;flex-direction:column;gap:12px">
              @foreach($messages as $msg)
                <div class="msg-item">
                  <div class="msg-icon" style="background:{{ $msg->sender_id == Auth::id() ? 'linear-gradient(135deg,#1a8a6e,#12705a)' : 'linear-gradient(135deg,#3b82f6,#2563eb)' }}">
                    {{ $msg->sender_id == Auth::id() ? 'OUT' : 'IN' }}
                  </div>
                  <div style="flex:1;min-width:0">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                      <div style="font-weight:600;font-size:.9rem;color:#18243a">{{ $msg->subject }}</div>
                      <span style="font-size:.75rem;color:#8898b0">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    <div style="font-size:.82rem;color:#526078;margin-bottom:4px">{{ $msg->body }}</div>
                    <div style="font-size:.75rem;color:#8898b0">
                      @if($msg->sender_id == Auth::id())
                        To: {{ $msg->receiver->name ?? 'Unknown' }}
                      @else
                        From: {{ $msg->sender->name ?? 'Unknown' }}
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

        <div style="margin-top:10px">
          <a href="{{ route('doctor.dashboard') }}" style="color:#1a8a6e;font-weight:600;font-size:.9rem">&larr; Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

