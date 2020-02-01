<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name')->comment('名称');
            $table->string('uri')->nullable()->comment('uri路径英文名称');
            $table->unsignedBigInteger('pid')->nullable()->default(0)->index()->comment('父类ID，0为顶级分类');
            $table->unsignedBigInteger('channeltype_id')->nullable()->comment('类型');
            $table->unsignedBigInteger('sort')->nullable()->index()->default(0)->comment('排序');
            $table->text('scontent')->nullable()->comment('简介');
            $table->text('content')->nullable()->comment('完整介绍');
            $table->string('link')->nullable()->comment('外部链接地址');
            $table->string('title')->nullable()->comment('SEO标题');
            $table->string('keywords')->nullable()->comment('SEO关键字');
            $table->string('description')->nullable()->comment('SEO描述');
            $table->string('cover')->nullable()->comment('封面图片地址');
            $table->unsignedTinyInteger('page')->nullable()->default(10)->comment('分页');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加软删除
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
            // 添加组合唯一索引
            $table->unique(['name', 'deleted_at']);
            // 添加外键关联
            $table->foreign('channeltype_id')->references('id')->on('channeltypes')->onDelete('set null');
        });
        // 表注释
        DB::statement("ALTER TABLE `channels` COMMENT'频道表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
