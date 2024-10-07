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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');

        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['group_id']);
        });
    }
};
