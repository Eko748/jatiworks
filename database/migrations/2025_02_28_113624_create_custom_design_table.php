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
        Schema::create('custom_design', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->string('item_name')->nullable();
            $table->string('code_design')->nullable();
            $table->double('price')->nullable();
            $table->text('desc')->nullable();
            $table->enum('status', array_column(OrderStatus::cases(), 'value'))->default(OrderStatus::WaitingForPayment->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_design');
    }
};
