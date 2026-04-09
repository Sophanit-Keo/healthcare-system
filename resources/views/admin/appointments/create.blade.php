@extends('admin.layout')

@section('content')

<div class="page-content active">

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-left">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('admin.appointments.index') }}" class="action-btn back-btn">
                    ←
                </a>
                <div>
                    <h1>Book Appointment</h1>
                    <p>Schedule a new patient visit.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Style Card -->
    <div class="modal-like small">

        <form action="#" method="POST">
            @csrf

            <div class="form-grid col1">

                <!-- Patient -->
                <div class="form-group">
                    <label class="form-label">Patient Name<span>*</span></label>
                    <input type="text" name="patient_name" class="form-input" placeholder="Full name" required>
                </div>

                <!-- Doctor -->
                <div class="form-group">
                    <label class="form-label">Doctor<span>*</span></label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">Select doctor</option>
                        <option>Dr. Stein Albert</option>
                        <option>Dr. Alexa Melvin</option>
                        <option>Dr. Rebecca Steffany</option>
                        <option>Dr. Pham Nguyen</option>
                        <option>Dr. Marcus Webb</option>
                    </select>
                </div>

                <!-- Department -->
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

                <!-- Date & Time -->
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

                <!-- Status -->
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option>Confirmed</option>
                        <option>Pending</option>
                        <option>Cancelled</option>
                        <option>In Progress</option>
                    </select>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea" placeholder="Reason for visit or notes…"></textarea>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer" style="margin-top:25px;">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Appointment
                </button>
            </div>

        </form>
    </div>

</div>

@endsection