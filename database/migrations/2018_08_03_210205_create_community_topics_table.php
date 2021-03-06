<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->text('content')->comment('内容');
            $table->integer('zone_id')->unsigned()->comment('一级分类');
            $table->integer('section_id')->unsigned()->comment('二级分类');
            $table->integer('user_id')->unsigned()->comment('发布者');
            $table->integer('reply_count')->unsigned()->default(0)->comment('回复数');
            $table->integer('thumb_up_count')->unsigned()->default(0)->comment('赞数');
            $table->integer('view_count')->unsigned()->default(0)->comment('查看数');
            $table->integer('order')->default(0)->comment('排序');
            $table->boolean('is_excellent')->default(false)->comment('是否精华');
            $table->integer('last_reply_id')->unsigned()->nullable()->comment('最后回复ID');
            $table->timestamp('last_reply_at')->nullable()->comment('最后回复时间');
            $table->string('status')->default('publish')->comment('status:{"publish":"公开","hidden":"隐藏/浏览"}');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_topics');
    }
}
