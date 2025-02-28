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
        Schema::create('design_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')->constrained('order')->onDelete('cascade');
            $table->foreignId('id_tracking_step_design')->constrained('tracking_step_design')->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_tracking');
    }
};
