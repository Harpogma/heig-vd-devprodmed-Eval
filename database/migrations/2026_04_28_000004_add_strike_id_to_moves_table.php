<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('moves', function (Blueprint $table) {
            $table->foreignId('strike_id')->nullable()->constrained('strikes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('moves', function (Blueprint $table) {
            $table->dropForeign(['strike_id']);
            $table->dropColumn('strike_id');
        });
    }
};
