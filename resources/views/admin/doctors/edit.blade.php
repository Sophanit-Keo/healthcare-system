@extends('admin.layout')

@section('content')

<div class="page-content active">

    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.doctors.index') }}" class="action-btn back-btn">←</a>
                <div>
                    <h1>Edit Doctor</h1>
                    <p>Update the doctor's profile details.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-like">
        <form action="{{ route('admin.doctors.update', $doctor->DoctorID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">First Name<span>*</span></label>
                    <input type="text" name="first_name" class="form-input" value="{{ old('first_name', $doctor->first_name) }}" required>
                    @error('first_name') <span style="color:red">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Last Name<span>*</span></label>
                    <input type="text" name="last_name" class="form-input" value="{{ old('last_name', $doctor->last_name) }}" required>
                    @error('last_name') <span style="color:red">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email<span>*</span></label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $doctor->email) }}" required>
                    @error('email') <span style="color:red">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input" value="{{ old('phone', $doctor->phone) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Specialisation<span>*</span></label>
                    <select name="department" class="form-select" required>
                        <option value="">Select department</option>
                        @foreach(['General Health','Cardiology','Dental','Neurology','Orthopaedics'] as $dept)
                            <option value="{{ $dept }}" {{ old('department', $doctor->specialization) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="available" {{ old('status', $doctor->status) === 'available'   ? 'selected' : '' }}>Available</option>
                        <option value="onleave"   {{ old('status', $doctor->status) === 'onleave'     ? 'selected' : '' }}>On Leave</option>
                        <option value="unavailable" {{ old('status', $doctor->status) === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Years of Experience</label>
                    <input type="number" name="experience" class="form-input" value="{{ old('experience', $doctor->years_of_experience) }}" min="0" max="50">
                </div>

                <div class="form-group">
                    <label class="form-label">Consultation Fee ($)</label>
                    <input type="number" name="fee" class="form-input" value="{{ old('fee', $doctor->consultation_fee) }}" min="0">
                </div>

                <div class="form-group full">
                    <label class="form-label">Biography / Notes</label>
                    <textarea name="bio" class="form-textarea">{{ old('bio', $doctor->biography_note) }}</textarea>
                </div>

            </div>

            <div class="modal-footer" style="margin-top:30px;">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection
