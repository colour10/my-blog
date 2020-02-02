<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInfoTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_tag', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->unsignedBigInteger('info_id')->comment('信息ID');
            $table->unsignedBigInteger('tag_id')->comment('标签ID');
            $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->index()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加外键关联
            $table->foreign('info_id')->references('id')->on('infos')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
        // 表注释
        DB::statement("ALTER TABLE `info_tag` COMMENT'信息标签关联表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_tag');
    }
}
