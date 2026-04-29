<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('move_id')->constrained('moves')->onDelete('cascade');
            $table->enum('type', ['buff', 'nerf']);
            $table->tinyInteger('weight');
            $table->timestamps();

            $table->unique(['user_id', 'move_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
