<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pet_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade'); // pet_id dış anahtar, pets tablosuna bağlanıyor ve pet silindiğinde pet_foods siliniyor
            $table->string('food_type');
            $table->string('food_brand');
            $table->integer('amount');
            $table->integer('meal_repeat');
            $table->integer('time_period');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_foods');
    }
};
