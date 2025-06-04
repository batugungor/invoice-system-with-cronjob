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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unique(['user_id', 'due_date']);
            $table->foreignId('user_id');
            $table->dateTime('due_date');
            $table->dateTime('paid_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed', 'overdue'])->default('pending');
            $table->decimal('total', 10)->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_line_items', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('invoice_id');
            $table->uuid('subscription_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('amount')->default(1);
            $table->float('unit_price', 10);
            $table->float('total_price', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_line_items');
    }
};
