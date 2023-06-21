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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('content')->comment('メッセージ内容');
            $table->foreignId('user_id')->comment('ユーザーの識別ID')
            ->nullable()
            ->default(null)
            ->constrained('users');
            $table->foreignId('talkroom_id')->comment('トークルームの識別ID')
            ->nullable()
            ->default(null)
            ->constrained('talkrooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
