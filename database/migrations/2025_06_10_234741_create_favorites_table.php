<?php

// database/migrations/xxxx_xx_xx_create_favorites_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'menu_item_id']); // لمنع التكرار
        });
    }

    public function down(): void {
        Schema::dropIfExists('favorites');
    }
};
