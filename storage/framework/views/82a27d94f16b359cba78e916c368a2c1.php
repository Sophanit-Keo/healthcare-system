<?php $__env->startSection('content'); ?>

<div class="page-content active">

    
    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="<?php echo e(route('admin.appointments.index')); ?>" class="action-btn back-btn">
                    ←
                </a>
                <div>
                    <h1>Book Appointment</h1>
                    <p>Schedule a new patient visit.</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal-like small">

        <form action="<?php echo e(route('admin.appointments.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-grid col1">

                
                <div class="form-group">
                    <label class="form-label">Patient Name<span>*</span></label>
                    <input type="text" name="patient_name" class="form-input" placeholder="Full name" value="<?php echo e(old('patient_name')); ?>" required>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Doctor<span>*</span></label>
                    <select name="doctor" class="form-select" required>
                        <option value="">Select doctor</option>
                        <option>Dr. Stein Albert</option>
                        <option>Dr. Alexa Melvin</option>
                        <option>Dr. Rebecca Steffany</option>
                        <option>Dr. Pham Nguyen</option>
                        <option>Dr. Marcus Webb</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Department<span>*</span></label>
                    <select name="department" class="form-select" required>
                        <option value="">Select department</option>
                        <option>General Health</option>
                        <option>Cardiology</option>
                        <option>Dental</option>
                        <option>Neurology</option>
                        <option>Orthopaedics</option>
                    </select>
                </div>

                
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Date<span>*</span></label>
                        <input type="date" name="date" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Time<span>*</span></label>
                        <input type="time" name="time" class="form-input" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option>Confirmed</option>
                        <option>Pending</option>
                        <option>Cancelled</option>
                        <option>In Progress</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea" placeholder="Reason for visit or notes…"></textarea>
                </div>

            </div>

            
            <div class="modal-footer" style="margin-top:25px;">
                <a href="<?php echo e(route('admin.appointments.index')); ?>" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Appointment
                </button>
            </div>

        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/appointments/create.blade.php ENDPATH**/ ?>