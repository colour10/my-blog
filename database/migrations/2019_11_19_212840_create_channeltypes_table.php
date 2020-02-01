<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChanneltypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channeltypes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name')->comment('名称');
            $table->string('description')->nullable()->comment('简介');
            $table->string('link')->nullable()->comment('外部链接地址');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加软删除
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
            // 添加组合唯一索引
            $table->unique(['name', 'deleted_at']);
        });
        // 表注释
        DB::statement("ALTER TABLE `channeltypes` COMMENT'频道类型表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channeltypes');
    }
}
