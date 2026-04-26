<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (! Schema::hasColumn('appointments', 'patient_id')) {
                $table->foreignId('patient_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('patients')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('appointments', 'facility_id')) {
                $table->foreignId('facility_id')
                    ->nullable()
                    ->after('patient_id')
                    ->constrained('facilities')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('appointments', 'department_id')) {
                $table->foreignId('department_id')
                    ->nullable()
                    ->after('facility_id')
                    ->constrained('departments')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('appointments', 'health_staff_id')) {
                $table->foreignId('health_staff_id')
                    ->nullable()
                    ->after('department_id')
                    ->constrained('health_staff')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('appointments', 'appointment_date')) {
                $table->date('appointment_date')->nullable()->after('department');
            }

            if (! Schema::hasColumn('appointments', 'appointment_time')) {
                $table->time('appointment_time')->nullable()->after('appointment_date');
            }

            if (! Schema::hasColumn('appointments', 'reason')) {
                $table->string('reason', 255)->nullable()->after('appointment_time');
            }

            if (! Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable()->after('reason');
            }
        });

        if (Schema::hasColumn('appointments', 'patient_id') && Schema::hasColumn('appointments', 'appointment_date')) {
            try {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->index(['patient_id', 'appointment_date'], 'appointments_patient_id_appointment_date_index');
                });
            } catch (Throwable $e) {
                // Ignore if index already exists (or driver doesn't support it).
            }
        }
    }

    public function down(): void
    {
        try {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropIndex('appointments_patient_id_appointment_date_index');
            });
        } catch (Throwable $e) {
            // ignore
        }

        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'notes')) {
                $table->dropColumn(['notes']);
            }
            if (Schema::hasColumn('appointments', 'reason')) {
                $table->dropColumn(['reason']);
            }
            if (Schema::hasColumn('appointments', 'appointment_time')) {
                $table->dropColumn(['appointment_time']);
            }
            if (Schema::hasColumn('appointments', 'appointment_date')) {
                $table->dropColumn(['appointment_date']);
            }

            if (Schema::hasColumn('appointments', 'health_staff_id')) {
                $table->dropConstrainedForeignId('health_staff_id');
            }
            if (Schema::hasColumn('appointments', 'department_id')) {
                $table->dropConstrainedForeignId('department_id');
            }
            if (Schema::hasColumn('appointments', 'facility_id')) {
                $table->dropConstrainedForeignId('facility_id');
            }
            if (Schema::hasColumn('appointments', 'patient_id')) {
                $table->dropConstrainedForeignId('patient_id');
            }
        });
    }
};
