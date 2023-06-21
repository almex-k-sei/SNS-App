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
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('ユーザーの識別ID（自分）')
            ->nullable()
            ->default(null)
            ->constrained('users');
            $table->foreignId('friend_id')->comment('ユーザーの識別ID（相手）')
            ->nullable()
            ->default(null)
            ->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
