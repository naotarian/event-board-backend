<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_management', function (Blueprint $table) {
            $table->integer('user_id')->after('id');
            $table->string('user_name')->nullable()->after('application_number')->comment('ユーザー名');
            $table->string('email')->nullable()->after('user_name')->comment('メールアドレス');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_management', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->dropColumn('email');
            $table->dropColumn('user_id');
        });
    }
};
