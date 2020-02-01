<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->unsignedBigInteger('info_id')->nullable()->comment('所属信息ID');
            $table->unsignedBigInteger('pid')->comment('父节点ID');
            $table->unsignedBigInteger('user_id')->nullable()->comment('评论用户ID');
            $table->text('content')->comment('评论内容');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加软删除
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
            // 添加外键关联
            $table->foreign('info_id')->references('id')->on('infos')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        // 表注释
        DB::statement("ALTER TABLE `comments` COMMENT'评论表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
