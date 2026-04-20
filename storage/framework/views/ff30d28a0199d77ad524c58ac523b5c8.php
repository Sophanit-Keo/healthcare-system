

<?php $__env->startPush('style'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
<div id="toast" style="position:fixed;top:30px;right:30px;z-index:9999;min-width:320px;max-width:420px;padding:18px 24px;border-radius:12px;color:#fff;font-weight:500;font-size:.95rem;box-shadow:0 8px 32px rgba(0,0,0,.18);display:flex;align-items:center;gap:12px;transform:translateX(120%);transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .4s;opacity:0;background:linear-gradient(135deg,#1a8a6e,#12705a)">
  <span style="font-size:22px">✅</span><span><?php echo e(session('success')); ?></span>
</div>
<script>document.addEventListener('DOMContentLoaded',function(){var t=document.getElementById('toast');if(t){setTimeout(function(){t.style.transform='translateX(0)';t.style.opacity='1'},100);setTimeout(function(){t.style.transform='translateX(120%)';t.style.opacity='0'},4000)}});</script>
<?php endif; ?>

<div class="page-hero overlay-dark" style="background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%);padding:60px 0 40px">
  <div class="page-container">
    <h1 style="color:#fff;margin-bottom:4px">💬 Chat with Doctor</h1>
    <p style="color:rgba(255,255,255,.7)">Send messages and get medical advice from our doctors.</p>
  </div>
</div>

<div class="bg-light">
  <div class="page-section" style="padding-top:0">
    <div style="margin-top:-2rem;position:relative;z-index:10">
      <div class="page-container">

        
        <div class="page-card">
          <h4 style="margin-bottom:18px;color:#18243a">Send a Message</h4>
          <form method="POST" action="<?php echo e(route('patient.send-message')); ?>" class="chat-form">
            <?php echo csrf_field(); ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
              <div>
                <label>Select Doctor</label>
                <select name="receiver_id" required>
                  <option value="">-- Choose a doctor --</option>
                  <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($doc->id); ?>">Dr. <?php echo e($doc->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['receiver_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:#dc2626;font-size:.8rem"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <div>
                <label>Subject</label>
                <input type="text" name="subject" placeholder="e.g. Follow-up question" value="<?php echo e(old('subject')); ?>" required>
                <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:#dc2626;font-size:.8rem"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
            </div>
            <div style="margin-bottom:14px">
              <label>Message</label>
              <textarea name="body" placeholder="Type your message here..." required><?php echo e(old('body')); ?></textarea>
              <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:#dc2626;font-size:.8rem"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <button type="submit" class="btn-send">Send Message</button>
          </form>
        </div>

        
        <div class="page-card">
          <h4 style="margin-bottom:14px;color:#18243a">Message History</h4>
          <?php if($messages->isEmpty()): ?>
          <div class="empty-state">
            <div style="font-size:40px;margin-bottom:8px">💬</div>
            No messages yet. Send one to get started!
          </div>
          <?php else: ?>
          <div style="display:flex;flex-direction:column;gap:12px">
            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="msg-item">
              <div class="msg-icon" style="background:<?php echo e($msg->sender_id == Auth::id() ? 'linear-gradient(135deg,#1a8a6e,#12705a)' : 'linear-gradient(135deg,#3b82f6,#2563eb)'); ?>">
                <?php echo e($msg->sender_id == Auth::id() ? '📤' : '📥'); ?>

              </div>
              <div style="flex:1;min-width:0">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                  <div style="font-weight:600;font-size:.9rem;color:#18243a"><?php echo e($msg->subject); ?></div>
                  <span style="font-size:.75rem;color:#8898b0"><?php echo e($msg->created_at->diffForHumans()); ?></span>
                </div>
                <div style="font-size:.82rem;color:#526078;margin-bottom:4px"><?php echo e($msg->body); ?></div>
                <div style="font-size:.75rem;color:#8898b0">
                  <?php if($msg->sender_id == Auth::id()): ?>
                    To: Dr. <?php echo e($msg->receiver->name ?? 'Unknown'); ?>

                  <?php else: ?>
                    From: Dr. <?php echo e($msg->sender->name ?? 'Unknown'); ?>

                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <?php endif; ?>
        </div>

        <div style="margin-top:10px">
          <a href="<?php echo e(route('dashboard')); ?>" style="color:#1a8a6e;font-weight:600;font-size:.9rem">← Back to Dashboard</a>
        </div>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layout.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/patient/chat.blade.php ENDPATH**/ ?>