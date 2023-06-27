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
        Schema::table('talkroom_user', function (Blueprint $table) {
            $table->unique(['talkroom_id','user_id'], 'unique_program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talkroom_user', function (Blueprint $table) {
            $table->dropUnique('unique_program');
        });
    }
};
