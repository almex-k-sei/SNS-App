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
        Schema::create('talkroom_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('talkroom_id')->comment('トークルームの識別ID');
            $table->bigInteger('user_id')->comment('ユーザーの識別ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talkroom_user');
    }
};
