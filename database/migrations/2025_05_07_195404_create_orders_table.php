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
      Schema::create('orders', function (Blueprint $table) {
    $table->id(); // رقم الطلب
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    // الشخص الذي قام بالطلب (زبون أو نادل...)
    $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
    // الطاولة التي تم تنفيذ الطلب عليها
    $table->enum('status', ['pending', 'preparing', 'served', 'paid', 'cancelled'])->default('pending');
    // حالة الطلب
    $table->timestamps(); // created_at و updated_at
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
