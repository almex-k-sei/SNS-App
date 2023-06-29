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
        Schema::table('talkrooms', function (Blueprint $table) {
            $table->foreignId('talkroom_id')->comment('トークルームの識別ID')
                ->nullable()
                ->default(null)
                ->constrained('talkrooms')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talkrooms', function (Blueprint $table) {
            $table->dropForeign(['talkroom_id']);
            $table->dropColumn('talkroom_id');
        });
    }
};
