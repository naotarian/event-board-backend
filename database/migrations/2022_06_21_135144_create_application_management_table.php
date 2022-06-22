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
        Schema::create('application_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->unsigned();
            $table->string('application_number', 128)->nullable()->comment('申込番号');
            $table->timestamp('application_date')->nullable()->comment('申込日時');
            $table->timestamp('cancel_date')->nullable()->comment('キャンセル日時');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE application_management COMMENT 'イベント申込管理テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_management');
    }
};
