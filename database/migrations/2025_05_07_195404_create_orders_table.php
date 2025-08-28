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
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
    $table->foreignId('table_id')->nullable()->constrained()->onDelete('set null'); // ✅ صار nullable
    $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null'); // ✅ لطلبات الديلفري
    $table->float('final_price', 10, 2)->default(0);
    $table->enum('status', [
                'requested',   // الطلب جديد
                'preparing',   // قيد التحضير
                'on_the_way',  // في الطريق
                'paid',        // تم الدفع
            ])->default('requested');

   $table->timestamps();



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
