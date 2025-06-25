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
     Schema::create('menu_items', function (Blueprint $table) {
    $table->id(); // معرف العنصر في القائمة
    $table->string('name'); // اسم الوجبة أو العنصر (مثلاً "بيتزا مارجريتا")
    $table->decimal('price', 10, 2); // السعر (مثلاً: 19.99)
    $table->text('description')->nullable(); // وصف تفصيلي (اختياري)
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    // ربط بالتصنيفات (categories)
    $table->string('image')->nullable(); // مسار الصورة (اختياري)
    $table->timestamps(); // created_at و updated_at
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
