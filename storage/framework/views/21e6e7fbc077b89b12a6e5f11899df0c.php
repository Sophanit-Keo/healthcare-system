<?php $__env->startSection('title', 'Patients'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content active" id="page-patients">
  <div class="page-header">
    <div class="page-header-left">
      <h1>Manage Patients</h1>
      <p>1,284 registered patients in the system.</p>
    </div>
    <a href="<?php echo e(route('admin.patients.create')); ?>" class="btn btn-primary <?php echo e(request()->routeIs('admin.patients.create') ? 'active' : ''); ?>">
      <div class="nav-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
      </div>
      Add Patient
    </a>
  </div>

  <div class="table-card">
    <div class="search-bar">
      <div class="search-input-wrap">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <form method="GET" action="<?php echo e(route('admin.patients.index')); ?>" style="display:contents">
          <?php if(request('status')): ?><input type="hidden" name="status" value="<?php echo e(request('status')); ?>"><?php endif; ?>
          <input type="text"
            name="search"
            value="<?php echo e(request('search')); ?>"
            placeholder="Search patients...">
        </form>
      </div>
      <div class="status-filter">
        <a href="<?php echo e(route('admin.patients.index', array_merge(request()->except('status','page'), []))); ?>"
          class="status-tab <?php echo e(request('status') == null ? 'active' : ''); ?>">
          All
        </a>
        <a href="<?php echo e(route('admin.patients.index', array_merge(request()->except('status','page'), ['status'=>'active']))); ?>"
          class="status-tab <?php echo e(request('status') == 'active' ? 'active' : ''); ?>">
          Active
        </a>
        <a href="<?php echo e(route('admin.patients.index', array_merge(request()->except('status','page'), ['status'=>'inactive']))); ?>"
          class="status-tab <?php echo e(request('status') == 'inactive' ? 'active' : ''); ?>">
          Inactive
        </a>
      </div>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Patient</th>
          <th>Phone</th>
          <th>Date of Birth</th>
          <th>Department</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td>
            <div class="user-cell">
              <div class="avatar av-green">
                <?php echo e(strtoupper(substr($patient->first_name ?? 'PP', 0, 2))); ?>

              </div>
              <div>
                <div class="user-name"><?php echo e($patient->last_name); ?> </div>
                <div class="user-email"><?php echo e($patient->email); ?></div>
              </div>
            </div>
          </td>

          <td style="color:var(--text-secondary)"><?php echo e($patient->phone); ?></td>

          <td style="color:var(--text-secondary)">
            <?php echo e($patient->updated_at ? $patient->updated_at->format('d M Y') : 'N/A'); ?>

          </td>

          <td>
            <span class="badge badge-green"><?php echo e($patient->department ?? 'General'); ?></span>
          </td>

          <td>
            <span class="badge <?php echo e(($patient->status == 'active') ? 'badge-green' : 'badge-red'); ?>">
              <?php echo e(ucfirst($patient->status ?? 'active')); ?>

            </span>
          </td>

          <td>
            <div style="display:flex; gap:8px;">

              
              <a href="<?php echo e(route('admin.patients.edit', $patient->PatientID)); ?>" class="action-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </a>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    <div class="pagination">
      <span class="pagination-info">Showing <?php echo e($patients->firstItem()); ?>–<?php echo e($patients->lastItem()); ?> of <?php echo e($patients->total()); ?> patients</span>
      <div class="pagination-btns">
        <?php if($patients->onFirstPage()): ?>
          <button class="pg-btn" disabled>‹</button>
        <?php else: ?>
          <a href="<?php echo e($patients->previousPageUrl()); ?>" class="pg-btn">‹</a>
        <?php endif; ?>

        <?php $__currentLoopData = $patients->getUrlRange(1, $patients->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e($url); ?>" class="pg-btn <?php echo e($page == $patients->currentPage() ? 'active' : ''); ?>"><?php echo e($page); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($patients->hasMorePages()): ?>
          <a href="<?php echo e($patients->nextPageUrl()); ?>" class="pg-btn">›</a>
        <?php else: ?>
          <button class="pg-btn" disabled>›</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\REACH\Desktop\Laravel assignment\resources\views/admin/patients/index.blade.php ENDPATH**/ ?>