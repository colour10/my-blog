<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('name')->comment('名称');
            $table->string('url')->index()->comment('链接地址');
            $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->index()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
        });
        // 表注释
        DB::statement("ALTER TABLE `links` COMMENT'友情链接表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
