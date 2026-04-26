@push('style')
<style>
  .page-container { width:100%; max-width:1400px; margin:auto; padding:0 24px; }
  .page-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:28px; margin-bottom:20px; }
  .page-card--narrow { max-width:900px; margin-left:auto; margin-right:auto; }
  .page-card--wide { max-width:1000px; margin-left:auto; margin-right:auto; }
  .page-card--form { max-width:860px; margin-left:auto; margin-right:auto; }
  .page-card h4 { margin-bottom:14px; color:#18243a; }
  .soft-table-wrap { overflow:auto; border-radius:12px; border:1px solid #eef2f7; }
  .soft-table { width:100%; border-collapse:separate; border-spacing:0; font-size:.9rem; }
  .soft-table thead th { background:#f7f9fc; color:#526078; font-weight:600; padding:14px 16px; border-bottom:1px solid #eef2f7; text-align:left; white-space:nowrap; }
  .soft-table tbody td { padding:14px 16px; border-bottom:1px solid #f0f3f8; color:#18243a; vertical-align:top; }
  .soft-table tbody tr:last-child td { border-bottom:none; }
  .soft-empty { text-align:center; padding:26px; }
  .soft-muted { color:#8898b0; font-size:.85rem; }
  .soft-badge { display:inline-block; font-size:.75rem; font-weight:600; padding:4px 10px; border-radius:999px; text-transform:capitalize; background:#eef2ff; color:#3b82f6; }
  .soft-badge.green { background:#e8f7f3; color:#1a8a6e; }
  .soft-badge.amber { background:#fff7ed; color:#d97706; }
  .soft-badge.red { background:#fef2f2; color:#dc2626; }
  .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
  .form-grid-1 { display:grid; grid-template-columns:1fr; gap:14px; }
  .form-label { font-weight:600; font-size:.85rem; color:#18243a; margin-bottom:6px; display:block; }
  .form-input, .form-select, .form-textarea { width:100%; border:1px solid #e2e8f0; border-radius:10px; padding:10px 12px; font-size:.9rem; background:#fff; }
  .form-textarea { resize:vertical; min-height:88px; }
  .form-error { color:#dc2626; font-size:.8rem; margin-top:6px; }
  .alert-success { background:#e8f7f3; color:#12705a; border:1px solid #cfe9e1; padding:12px 14px; border-radius:10px; font-size:.9rem; margin-bottom:14px; }
  .alert-danger { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; padding:12px 14px; border-radius:10px; font-size:.9rem; margin-bottom:14px; }
  .actions-row { display:flex; flex-wrap:wrap; gap:10px; align-items:center; justify-content:space-between; }
  .actions-row--spaced { gap:14px; }
  .btn-soft-primary { background:linear-gradient(135deg,#1a8a6e,#12705a); color:#fff; border:none; padding:10px 18px; border-radius:10px; font-weight:600; font-size:.9rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
  .btn-soft-primary:hover { opacity:.92; color:#fff; text-decoration:none; }
  .btn-soft-ghost { background:#f3f4f6; color:#6b7280; border:none; padding:10px 18px; border-radius:10px; font-weight:600; font-size:.9rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
  .btn-soft-ghost:hover { background:#e5e7eb; color:#4b5563; text-decoration:none; }
  .btn-soft-danger { background:#fef2f2; color:#b91c1c; border:none; padding:10px 18px; border-radius:10px; font-weight:600; font-size:.9rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
  .btn-soft-danger:hover { background:#fee2e2; color:#991b1b; text-decoration:none; }

  .patient-hero { background:linear-gradient(135deg,#0d2137 0%,#1a4a36 100%); padding:60px 0 40px; }
  .page-hero-title { color:#fff; margin-bottom:4px; }
  .page-hero-subtitle { color:rgba(255,255,255,.7); }
  .page-section--flush { padding-top:0 !important; }
  .page-float { margin-top:-2rem; position:relative; z-index:10; }
  .link-soft-primary { color:#1a8a6e; font-weight:600; text-decoration:none; }
  .link-soft-primary:hover { color:#12705a; text-decoration:underline; }
  .back-link { font-weight:600; font-size:.9rem; }
  .pre-line { white-space:pre-line; }
  @media(max-width:720px){
    .page-container{padding:0 14px}
    .form-grid{grid-template-columns:1fr}
  }
</style>
@endpush
