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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            $table->string('title'); // عنوان العرض
            $table->text('description')->nullable(); // وصف العرض
            $table->decimal('discount_percentage', 5, 2)->nullable(); // نسبة الخصم
            $table->decimal('new_price', 10, 2)->nullable(); // السعر الجديد بعد الخصم
            $table->string('image')->nullable(); // صورة العرض
            $table->date('start_date'); // تاريخ بداية العرض
            $table->date('end_date'); // تاريخ نهاية العرض
            $table->boolean('is_active')->default(true); // هل العرض مفعّل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
