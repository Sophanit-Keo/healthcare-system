@extends('admin.layout')

@section('content')

<div class="page-content active">

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.doctors.index') }}" class="action-btn back-btn">
                    ←
                </a>
                <div>
                    <h1>Add New Doctor</h1>
                    <p>Fill in the doctor's profile details.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card (Modal Style) -->
    <div class="modal-like">

        <form action="#" method="POST">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">First Name<span>*</span></label>
                    <input type="text" name="first_name" class="form-input" placeholder="Dr. First" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Last Name<span>*</span></label>
                    <input type="text" name="last_name" class="form-input" placeholder="Last name" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email<span>*</span></label>
                    <input type="email" name="email" class="form-input" placeholder="doctor@onehealth.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input" placeholder="+855 xxx xxx xxx">
                </div>

                <div class="form-group">
                    <label class="form-label">Specialisation<span>*</span></label>
                    <select name="department" class="form-select" required>
                        <option value="">Select department</option>
                        <option>General Health</option>
                        <option>Cardiology</option>
                        <option>Dental</option>
                        <option>Neurology</option>
                        <option>Orthopaedics</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option>Available</option>
                        <option>On Leave</option>
                        <option>Unavailable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Years of Experience</label>
                    <input type="number" name="experience" class="form-input" placeholder="e.g. 10" min="0" max="50">
                </div>

                <div class="form-group">
                    <label class="form-label">Consultation Fee ($)</label>
                    <input type="number" name="fee" class="form-input" placeholder="e.g. 120" min="0">
                </div>

                <div class="form-group full">
                    <label class="form-label">Biography / Notes</label>
                    <textarea name="bio" class="form-textarea" placeholder="Doctor's professional summary…"></textarea>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer" style="margin-top:30px;">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Doctor
                </button>
            </div>

        </form>
    </div>

</div>

@endsection