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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained();

            $table->foreignId('product_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->decimal('price', 10);
            $table->enum('status', ['active', 'paused', 'canceled'])->default('active');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->enum('custom_billing_cycle', ["weekly", "biweekly", "monthly", "quarterly", "yearly"])->nullable();
            $table->dateTime('next_billing_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
