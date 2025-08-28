<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['charge', 'deduct', 'refund', 'adjust']);
            $table->decimal('amount', 10, 2);
            $table->string('reference_type')->nullable(); // ex: 'order'
            $table->unsignedBigInteger('reference_id')->nullable(); // ex: order_id
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('wallet_transactions');
    }
};
