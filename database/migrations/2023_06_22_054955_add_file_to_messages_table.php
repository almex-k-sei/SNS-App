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
        Schema::table('messages', function (Blueprint $table) {
            $table->string('filename')->nullable()->comment('ファイル名を格納')->after('content');
            $table->string('filepath')->nullable()->comment('ファイルの情報を格納')->after('filename');
            $table->string('filetype')->nullable()->comment('ファイル名を格納')->after('filepath');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('filename');
            $table->dropColumn('filepath');
            $table->dropColumn('filetype');
        });
    }
};
