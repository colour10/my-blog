<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGuestbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guestbooks', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->unsignedBigInteger('user_id')->nullable()->comment('用户ID');
            $table->string('title')->index()->nullable()->default('')->comment('标题');
            $table->text('content')->comment('内容');
            $table->text('answer')->nullable()->comment('管理员回复');
            $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->index()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加软删除
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
            // 添加外键关联
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        // 表注释
        DB::statement("ALTER TABLE `guestbooks` COMMENT'留言表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guestbooks');
    }
}
