@extends('admin.layout')

@section('content')

<div class="page-content active">

    
    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.blog.index') }}" class="action-btn back-btn">
                    â†
                </a>
                <div>
                    <h1>New Blog Post</h1>
                    <p>Write and publish a health article.</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal-like large">

        <form action="#" method="POST">
            @csrf

            <div class="form-grid">

                
                <div class="form-group full">
                    <label class="form-label">Post Title<span>*</span></label>
                    <input type="text" name="title" class="form-input" placeholder="Enter an engaging titleâ€¦" required>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Category<span>*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="">Select category</option>
                        <option>Covid19</option>
                        <option>Nutrition</option>
                        <option>Mental Health</option>
                        <option>General</option>
                        <option>Cardiology</option>
                        <option>Dental</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Author<span>*</span></label>
                    <input type="text" name="author" class="form-input" placeholder="Author name" required>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option>Published</option>
                        <option>Draft</option>
                        <option>Archived</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Read Time (mins)</label>
                    <input type="number" name="read_time" class="form-input" placeholder="e.g. 5" min="1">
                </div>

                
                <div class="form-group full">
                    <label class="form-label">Content / Excerpt</label>
                    <textarea name="content" class="form-textarea" placeholder="Write the article content or excerptâ€¦" style="min-height:140px"></textarea>
                </div>

                
                <div class="form-group full">
                    <label class="form-label">Post Emoji / Thumbnail</label>
                    <input type="text" name="emoji" class="form-input" placeholder="e.g. ðŸŒ or ðŸ’Š">
                </div>

            </div>

            
            <div class="modal-footer" style="margin-top:30px;">
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Publish Post
                </button>
            </div>

        </form>
    </div>

</div>

@endsection


