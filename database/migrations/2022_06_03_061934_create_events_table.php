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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('title', 512)->nullable()->comment('イベントのタイトル');
            $table->string('thumbnail', 256)->nullable()->comment('サムネイル画像');
            $table->integer('number_of_applicants')->nullable()->comment('募集人数');
            $table->date('event_date')->nullable()->comment('イベントの開催日');
            $table->string('post_code')->nullable()->comment('開催場所の郵便番号');
            $table->string('address', 256)->nullable()->comment('開催場所住所');
            $table->string('other_address', 256)->nullable()->comment('開催場所住所の建物名以下');
            $table->timestamp('event_start')->nullable()->comment('イベント開始日時');
            $table->timestamp('event_end')->nullable()->comment('イベント終了日時');
            $table->timestamp('recruit_start')->nullable()->comment('イベント募集開始日時');
            $table->timestamp('recruit_end')->nullable()->comment('イベント募集終了日時');
            $table->text('overview')->nullable()->comment('イベント概要');
            $table->text('theme')->nullable()->comment('イベントテーマ');
            $table->string('email')->nullable()->comment('お問い合わせ用メールアドレス');
            $table->boolean('event_display')->default(1)->nullable()->comment('検索結果表示フラグ');
            $table->json('event_tags')->nullable()->comemnt('イベントタグ');
            $table->text('recommendation')->nullable()->comment('こんな方におすすめ');
            $table->text('notes')->nullable()->comment('注意事項');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE events COMMENT 'イベントテーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
