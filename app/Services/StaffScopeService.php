<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class StaffScopeService
{
    public function enforceFacilityScope(User $user, ?int $facilityId): void
    {
        if ($user->hasRole('admin')) {
            return;
        }

        if (! $user->hasAnyRole(['doctor', 'nurse', 'receptionist'])) {
            return;
        }

        $staff = $user->healthStaff;
        if (! $staff) {
            throw ValidationException::withMessages([
                'staff' => ['Staff profile not found for this account.'],
            ]);
        }

        if (! $facilityId) {
            throw ValidationException::withMessages([
                'facility_id' => ['Facility is required for staff-scoped actions.'],
            ]);
        }

        if ((int) $staff->facility_id !== (int) $facilityId) {
            throw ValidationException::withMessages([
                'facility_id' => ['You are not scoped to this facility.'],
            ]);
        }
    }
}
