

<?php $__env->startSection('content'); ?>

<div class="page-content active">

    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="<?php echo e(route('admin.doctors.index')); ?>" class="action-btn back-btn">←</a>
                <div>
                    <h1>Edit Doctor</h1>
                    <p>Update the doctor's profile details.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-like">
        <form action="<?php echo e(route('admin.doctors.update', $doctor->DoctorID)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">First Name<span>*</span></label>
                    <input type="text" name="first_name" class="form-input" value="<?php echo e(old('first_name', $doctor->first_name)); ?>" required>
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Last Name<span>*</span></label>
                    <input type="text" name="last_name" class="form-input" value="<?php echo e(old('last_name', $doctor->last_name)); ?>" required>
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Email<span>*</span></label>
                    <input type="email" name="email" class="form-input" value="<?php echo e(old('email', $doctor->email)); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input" value="<?php echo e(old('phone', $doctor->phone)); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Specialisation<span>*</span></label>
                    <select name="department" class="form-select" required>
                        <option value="">Select department</option>
                        <?php $__currentLoopData = ['General Health','Cardiology','Dental','Neurology','Orthopaedics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept); ?>" <?php echo e(old('department', $doctor->specialization) === $dept ? 'selected' : ''); ?>><?php echo e($dept); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="available" <?php echo e(old('status', $doctor->status) === 'available'   ? 'selected' : ''); ?>>Available</option>
                        <option value="onleave"   <?php echo e(old('status', $doctor->status) === 'onleave'     ? 'selected' : ''); ?>>On Leave</option>
                        <option value="unavailable" <?php echo e(old('status', $doctor->status) === 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Years of Experience</label>
                    <input type="number" name="experience" class="form-input" value="<?php echo e(old('experience', $doctor->years_of_experience)); ?>" min="0" max="50">
                </div>

                <div class="form-group">
                    <label class="form-label">Consultation Fee ($)</label>
                    <input type="number" name="fee" class="form-input" value="<?php echo e(old('fee', $doctor->consultation_fee)); ?>" min="0">
                </div>

                <div class="form-group full">
                    <label class="form-label">Biography / Notes</label>
                    <textarea name="bio" class="form-textarea"><?php echo e(old('bio', $doctor->biography_note)); ?></textarea>
                </div>

            </div>

            <div class="modal-footer" style="margin-top:30px;">
                <a href="<?php echo e(route('admin.doctors.index')); ?>" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/doctors/edit.blade.php ENDPATH**/ ?>