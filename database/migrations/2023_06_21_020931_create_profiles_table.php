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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('表示するユーザーの名前');
            $table->string('image')->comment('ストレージに保存されている実際のファイルの名前');
            $table->string('birth')->comment('ユーザーの生年月日');
            $table->string('description')->comment('ユーザーの一言');
            $table->foreignId('user_id')->comment('ユーザーの識別ID')
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
        Schema::dropIfExists('profiles');
    }
};
