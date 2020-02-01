<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('title')->comment('标题');
            $table->unsignedBigInteger('channel_id')->nullable()->comment('所属频道ID');
            $table->text('scontent')->nullable()->comment('简介');
            $table->text('content')->comment('完整介绍');
            $table->string('keywords')->nullable()->comment('SEO关键字');
            $table->string('description')->nullable()->comment('SEO描述');
            $table->string('cover')->nullable()->comment('封面图片地址');
            $table->unsignedBigInteger('click')->nullable()->default(1)->comment('读取次数');
            $table->unsignedBigInteger('sort')->nullable()->default(0)->comment('排序');
            $table->timestamp('crontab_at')->nullable()->comment('定时发布时间');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加软删除
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
            // 添加组合唯一索引
            $table->unique(['title', 'deleted_at']);
            // 添加外键关联
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('set null');
        });
        // 表注释
        DB::statement("ALTER TABLE `infos` COMMENT'信息表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infos');
    }
}
