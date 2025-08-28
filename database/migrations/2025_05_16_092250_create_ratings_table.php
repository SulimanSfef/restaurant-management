<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
        $table->decimal('rating', 2, 1);
        $table->text('comment')->nullable();
        $table->unique(['user_id', 'menu_item_id']);
        $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
