@extends('admin.layout')

@section('content')

<div class="page-content active">

    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.patients.index') }}" class="action-btn back-btn">&larr;</a>
                <h1>Edit Patient</h1>
            </div>
            <p>Update patient profile details.</p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $fullName = trim($patient->user->name ?? '');
                $nameParts = preg_split('/\\s+/', $fullName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
            @endphp

            @if($errors->any())
                <div style="margin-bottom:16px;padding:12px 14px;background:#fef2f2;color:#dc2626;border-radius:8px">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-grid">
                    <div>
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $firstName) }}" required>
                        @error('first_name') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $lastName) }}" required>
                        @error('last_name') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $patient->user->email ?? '') }}" required>
                        @error('email') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? ($patient->user->phone ?? '')) }}" required>
                        @error('phone') <span style="color:red">{{ $message }}</span> @enderror
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
                            <option value="other" {{ old('gender', $patient->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Additional Information</h3>
                <div class="form-grid">
                    <div>
                        <label>Status</label>
                        <select name="status">
                            <option value="active"   {{ old('status', $patient->user->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $patient->user->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="full">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ old('address', $patient->address) }}" placeholder="Street, city, province...">
                        @error('address') <span style="color:red">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Blood Type</label>
                        <input type="text" name="blood_type" value="{{ old('blood_type', $patient->blood_type) }}" placeholder="e.g. O+, A-">
                        @error('blood_type') <span style="color:red">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Emergency Contact Name</label>
                        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" placeholder="Contact name">
                        @error('emergency_contact_name') <span style="color:red">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label>Emergency Contact Phone</label>
                        <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" placeholder="+855 xxx xxx xxx">
                        @error('emergency_contact_phone') <span style="color:red">{{ $message }}</span> @enderror
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
