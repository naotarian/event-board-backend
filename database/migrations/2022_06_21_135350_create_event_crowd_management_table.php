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
        Schema::create('event_crowd_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->unsigned();
            $table->integer('number_of_applicants')->nullable()->comment('募集人数');
            $table->integer('current_number_of_applicants')->nullable()->default(0)->comment('現在の人数');
            $table->boolean('saturated')->nullable()->default(false)->comment('募集人数に達したかフラグ');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE event_crowd_management COMMENT 'イベント人数管理テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_crowd_management');
    }
};
