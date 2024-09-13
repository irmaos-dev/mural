<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('author_follower', function (Blueprint $table): void {
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');

            $table->unique(['author_id', 'follower_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('author_follower');
    }
};
