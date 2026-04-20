<?php $__env->startSection('content'); ?>

<div class="page-content active">

    
    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="<?php echo e(route('admin.patients.index')); ?>" class="action-btn back-btn">
                    ←
                </a>
                <h1>New Patient</h1>
            </div>
            <p>Create a new patient profile with medical details.</p>
        </div>
    </div>

    
   <div class="form-card">
    <form action="<?php echo e(route('admin.patients.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-section">
            <h3>Personal Information</h3>

            <div class="form-grid">
                <div>
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="John" value="<?php echo e(old('first_name')); ?>" required>
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                 <div>
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Doe" value="<?php echo e(old('last_name')); ?>" required>
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" placeholder="john@email.com" value="<?php echo e(old('email')); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="+855 xxx xxx xxx" value="<?php echo e(old('phone')); ?>" required>
                </div>

                <div>
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>">
                </div>

                <div>
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Medical Information</h3>
            <div class="form-grid">
                <div>
                    <label>Department</label>
                    <select name="department">
                        <option value="General">General</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="Dental">Dental</option>
                    </select>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="full">
                    <label>Medical Notes</label>
                    <textarea name="notes" rows="4"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="<?php echo e(route('admin.patients.index')); ?>" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Save Patient</button>
        </div>
    </form>
</div>

</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/patients/create.blade.php ENDPATH**/ ?>