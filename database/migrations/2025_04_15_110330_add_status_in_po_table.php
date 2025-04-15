<?php

use App\Enums\OrderStatus;
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
        Schema::table('po', function (Blueprint $table) {
            $table->enum('status', array_column(OrderStatus::cases(), 'value'))->after('dp')->default(OrderStatus::NotCompleted->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('po', function (Blueprint $table) {
            //
        });
    }
};
