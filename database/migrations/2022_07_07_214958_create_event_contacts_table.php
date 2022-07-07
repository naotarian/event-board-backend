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
        Schema::create('event_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_name')->nullable()->comment('ユーザー名');
            $table->string('email')->nullable()->comment('メールアドレス');
            $table->unsignedBigInteger('event_id')->unsigned();
            $table->string('contact_number', 128)->nullable()->comment('お問い合わせ番号');
            $table->timestamp('contact_date')->nullable()->comment('お問い合わせ日時');
            $table->text('contents')->nullable()->comment('お問い合わせ内容');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE application_management COMMENT 'イベントお問い合わせテーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_contacts');
    }
};
