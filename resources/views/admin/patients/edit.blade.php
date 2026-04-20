@extends('admin.layout')

@section('content')

<div class="page-content active">

    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.patients.index') }}" class="action-btn back-btn">←</a>
                <h1>Edit Patient</h1>
            </div>
            <p>Update patient profile details.</p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.patients.update', $patient->PatientID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-grid">
                    <div>
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                        @error('first_name') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                        @error('last_name') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $patient->email) }}" required>
                        @error('email') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" required>
                    </div>
                    <div>
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}">
                    </div>
                    <div>
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select</option>
                            <option value="male"   {{ old('gender', $patient->gender) === 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>Female</option>
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
                            @foreach(['General Health','Cardiology','Dental','Neurology','Orthopaedics'] as $dept)
                                <option value="{{ $dept }}" {{ old('department', $patient->department) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Status</label>
                        <select name="status">
                            <option value="active"   {{ old('status', $patient->status) === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $patient->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="full">
                        <label>Medical Notes</label>
                        <textarea name="notes" rows="4">{{ old('notes', $patient->notes) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.patients.index') }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection
