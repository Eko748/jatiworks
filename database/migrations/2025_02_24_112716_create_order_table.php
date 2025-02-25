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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->string('id_katalog')->nullable();
            $table->string('item_name')->nullable();
            $table->string('material')->nullable();
            $table->integer('qty')->nullable();
            $table->double('price')->nullable();
            $table->enum('status', ['Waiting for Payment', 'Not Completed', 'Payment Completed'])->default('Waiting for Payment');
            $table->decimal('length')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('weight')->nullable();
            $table->text('desc');
            $table->enum('unit',['mm', 'm', 'cm']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
