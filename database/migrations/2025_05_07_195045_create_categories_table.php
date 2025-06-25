<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
      Schema::create('categories', function (Blueprint $table) {
        $table->id(); // معرف فريد
        $table->string('name'); // اسم التصنيف (مثلاً "مشروبات")
        $table->text('description'); // وصف التصنيف
        $table->timestamps(); // created_at و updated_at
});

    }


    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
