<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name')->index()->nullable()->default('')->comment('名称');
            $table->string('url')->index()->nullable()->default('')->comment('上传路径');
            $table->unsignedBigInteger('sort')->index()->default('0')->comment('排序');
            $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->index()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
        });
        // 表注释
        DB::statement("ALTER TABLE `banners` COMMENT'幻灯片表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
