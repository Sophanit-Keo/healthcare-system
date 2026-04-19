  @extends('admin.layout')
  @section('title', 'Blog / News')
  @section('content')
  <!-- ══════════════════════
       PAGE: BLOG
  ══════════════════════ -->
  <div class="page-content active" id="page-blog">
    <div class="page-header">
      <div class="page-header-left">
        <h1>Blog / News Management</h1>
        <p>Create, edit and publish health articles and news.</p>
      </div>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
              <div class="nav-icon">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                  </svg>
              </div>
              Add Post
          </a>
    </div>

    <div class="table-card">
      <div class="search-bar">
        <div class="search-input-wrap">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          <input type="text" placeholder="Search posts by title or category…">
        </div>
        <div class="status-filter">
          <button class="status-tab active">All</button>
          <button class="status-tab">Published</button>
          <button class="status-tab">Draft</button>
          <button class="status-tab">Archived</button>
        </div>
        <select class="filter-select" style="margin-left:auto">
          <option>All Categories</option>
          <option>Covid19</option>
          <option>Nutrition</option>
          <option>Mental Health</option>
          <option>General</option>
        </select>
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th>Post</th>
            <th>Category</th>
            <th>Author</th>
            <th>Published</th>
            <th>Views</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="user-cell">
                <div class="post-thumb-wrap">🌍</div>
                <div><div class="user-name">List of Countries without Coronavirus Case</div><div class="user-email">5 min read</div></div>
              </div>
            </td>
            <td><span class="badge badge-blue">Covid19</span></td>
            <td style="color:var(--text-secondary)">Roger Adams</td>
            <td style="color:var(--text-secondary);font-size:0.83rem">20 Mar 2026</td>
            <td style="font-weight:600;color:var(--text-primary)">4,218</td>
            <td><span class="badge badge-green">Published</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
          <tr>
            <td>
              <div class="user-cell">
                <div class="post-thumb-wrap">📰</div>
                <div><div class="user-name">Recovery Room: News beyond the Pandemic</div><div class="user-email">8 min read</div></div>
              </div>
            </td>
            <td><span class="badge badge-blue">Covid19</span></td>
            <td style="color:var(--text-secondary)">Roger Adams</td>
            <td style="color:var(--text-secondary);font-size:0.83rem">27 Feb 2026</td>
            <td style="font-weight:600;color:var(--text-primary)">3,105</td>
            <td><span class="badge badge-green">Published</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
          <tr>
            <td>
              <div class="user-cell">
                <div class="post-thumb-wrap">🍭</div>
                <div><div class="user-name">What is the Impact of Eating Too Much Sugar?</div><div class="user-email">6 min read</div></div>
              </div>
            </td>
            <td><span class="badge badge-amber">Nutrition</span></td>
            <td style="color:var(--text-secondary)">Diego Simmons</td>
            <td style="color:var(--text-secondary);font-size:0.83rem">27 Jan 2026</td>
            <td style="font-weight:600;color:var(--text-primary)">6,892</td>
            <td><span class="badge badge-green">Published</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
          <tr>
            <td>
              <div class="user-cell">
                <div class="post-thumb-wrap">🧠</div>
                <div><div class="user-name">Managing Anxiety in Post-Pandemic Life</div><div class="user-email">Draft — not yet published</div></div>
              </div>
            </td>
            <td><span class="badge badge-purple">Mental Health</span></td>
            <td style="color:var(--text-secondary)">Dr. Pham Nguyen</td>
            <td style="color:var(--text-muted);font-size:0.83rem">—</td>
            <td style="color:var(--text-muted)">—</td>
            <td><span class="badge badge-gray">Draft</span></td>
            <td><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button><button class="action-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button><button class="action-btn danger"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <span class="pagination-info">Showing 1–4 of 28 posts</span>
        <div class="pagination-btns">
          <button class="pg-btn">‹</button>
          <button class="pg-btn active">1</button>
          <button class="pg-btn">2</button>
          <button class="pg-btn">3</button>
          <button class="pg-btn">›</button>
        </div>
      </div>
    </div>
  </div><!-- /page-blog -->
  @endsection