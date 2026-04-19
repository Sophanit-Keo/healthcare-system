<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lab_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lab_order_id')->constrained()->cascadeOnDelete();

            $table->string('test_code', 50)->nullable();
            $table->string('test_name', 150);
            $table->string('specimen', 100)->nullable();
            $table->enum('status', ['ordered', 'collected', 'resulted', 'cancelled'])->default('ordered');

            $table->text('result')->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('reference_range', 100)->nullable();

            $table->timestamp('collected_at')->nullable();
            $table->timestamp('resulted_at')->nullable();

            $table->timestamps();

            $table->index(['lab_order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_order_items');
    }
};
