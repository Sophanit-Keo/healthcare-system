<?php $__env->startSection('title', 'Doctor'); ?>
<?php $__env->startSection('content'); ?>

  <div class="page-content active" id="page-doctors">
    <div class="page-header">
      <div class="page-header-left">
        <h1>Manage Doctors</h1>
        <p>47 specialists across 6 departments.</p>
      </div>
              <a href="<?php echo e(route('admin.doctors.create')); ?>" class="btn btn-primary">
              <div class="nav-icon">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                  </svg>
              </div>
              Add Doctor
          </a>
    </div>

    <div class="table-card">
      <div class="search-bar">
        <form method="GET" action="<?php echo e(route('admin.doctors.index')); ?>" style="display:contents">
          <div class="search-input-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by name or specialisation…">
          </div>
          <?php if(request('status')): ?><input type="hidden" name="status" value="<?php echo e(request('status')); ?>"><?php endif; ?>
          <?php if(request('department')): ?><input type="hidden" name="department" value="<?php echo e(request('department')); ?>"><?php endif; ?>
        </form>
        <div class="status-filter">
          <a href="<?php echo e(route('admin.doctors.index', array_merge(request()->except('status','page'), []))); ?>"
             class="status-tab <?php echo e(!request('status') ? 'active' : ''); ?>">All</a>
          <a href="<?php echo e(route('admin.doctors.index', array_merge(request()->except('status','page'), ['status'=>'available']))); ?>"
             class="status-tab <?php echo e(request('status')==='available' ? 'active' : ''); ?>">Available</a>
          <a href="<?php echo e(route('admin.doctors.index', array_merge(request()->except('status','page'), ['status'=>'onleave']))); ?>"
             class="status-tab <?php echo e(request('status')==='onleave' ? 'active' : ''); ?>">On Leave</a>
        </div>
        <form method="GET" action="<?php echo e(route('admin.doctors.index')); ?>" style="margin-left:auto">
          <?php if(request('search')): ?><input type="hidden" name="search" value="<?php echo e(request('search')); ?>"><?php endif; ?>
          <?php if(request('status')): ?><input type="hidden" name="status" value="<?php echo e(request('status')); ?>"><?php endif; ?>
          <select name="department" class="filter-select" onchange="this.form.submit()">
            <option value="">All Departments</option>
            <?php $__currentLoopData = ['General Health','Cardiology','Dental','Neurology','Orthopaedics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($dept); ?>" <?php echo e(request('department') === $dept ? 'selected' : ''); ?>><?php echo e($dept); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </form>
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th>Doctor</th>
            <th>Specialisation</th>
            <th>Patients</th>
            <th>Rating</th>
            <th>Schedule Load</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td>
              <div class="user-cell">
                <div class="avatar av-green"><?php echo e(strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1))); ?></div>
                <div>
                  <div class="user-name">Dr. <?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?></div>
                  <div class="user-email"><?php echo e($doctor->email); ?></div>
                </div>
              </div>
            </td>
            <td><span class="badge badge-blue"><?php echo e($doctor->specialization); ?></span></td>
            <td style="color:var(--text-secondary);font-weight:500">—</td>
            <td><span style="color:var(--amber);font-weight:600">—</span></td>
            <td>
              <div class="progress-wrap" style="width:120px">
                <div class="progress-bg"><div class="progress-fill" style="width:<?php echo e($doctor->schedule_load); ?>%;background:var(--green)"></div></div>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px"><?php echo e($doctor->schedule_load); ?>% full</div>
              </div>
            </td>
            <td>
              <span class="badge <?php echo e($doctor->status === 'available' ? 'badge-green' : ($doctor->status === 'onleave' ? 'badge-amber' : 'badge-red')); ?>">
                <?php echo e(ucfirst($doctor->status)); ?>

              </span>
            </td>
            <td>
              <div style="display:flex;gap:8px;align-items:center;">
                <a href="<?php echo e(route('admin.doctors.edit', $doctor->DoctorID)); ?>" class="action-btn">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="<?php echo e(route('admin.doctors.destroy', $doctor->DoctorID)); ?>" onsubmit="return confirm('Delete this doctor?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="action-btn danger">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted)">No doctors found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="pagination">
        <span class="pagination-info">Showing <?php echo e($doctors->firstItem() ?? 0); ?>–<?php echo e($doctors->lastItem() ?? 0); ?> of <?php echo e($doctors->total()); ?> doctors</span>
        <div class="pagination-btns">
          <?php if($doctors->onFirstPage()): ?>
            <button class="pg-btn" disabled>‹</button>
          <?php else: ?>
            <a href="<?php echo e($doctors->previousPageUrl()); ?>" class="pg-btn">‹</a>
          <?php endif; ?>

          <?php $__currentLoopData = $doctors->getUrlRange(1, $doctors->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($url); ?>" class="pg-btn <?php echo e($page == $doctors->currentPage() ? 'active' : ''); ?>"><?php echo e($page); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <?php if($doctors->hasMorePages()): ?>
            <a href="<?php echo e($doctors->nextPageUrl()); ?>" class="pg-btn">›</a>
          <?php else: ?>
            <button class="pg-btn" disabled>›</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/doctors/index.blade.php ENDPATH**/ ?>