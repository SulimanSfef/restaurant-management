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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // الطلب الأساسي
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade'); // المنتج المطلوب
            $table->integer('quantity')->default(1); // عدد القطع
            $table->text('note')->nullable(); // ملاحظات اختيارية (مثلاً بدون بصل)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
