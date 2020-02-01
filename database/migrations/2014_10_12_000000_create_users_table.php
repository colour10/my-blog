<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键ID');
            $table->string('username')->comment('用户名');
            $table->string('password')->comment('用户密码');
            $table->rememberToken()->nullable()->comment('验证登录状态凭证');
            $table->char('mobile', 11)->nullable()->index()->comment('用户手机号');
            $table->string('email')->nullable()->index()->comment('用户邮箱');
            $table->timestamp('email_verified_at')->nullable()->comment('邮箱验证时间');
            $table->boolean('is_active')->default(false)->comment('用户状态：1-启用；0-禁用');
            $table->string('activation_token')->nullable()->comment('激活令牌');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('weixin_openid')->nullable()->index()->comment('微信openid');
            $table->string('weixin_unionid')->nullable()->index()->comment('微信unionid');
            $table->string('qq')->nullable()->index()->comment('用户QQ');
            $table->timestamp('lastlogin_at')->nullable()->comment('用户最后登录时间');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE 
CURRENT_TIMESTAMP'))->comment('更新时间');
            // 添加软删除
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
            // 添加组合唯一索引
            $table->unique(['username', 'deleted_at']);
        });
        // 表注释
        DB::statement("ALTER TABLE `users` COMMENT'用户表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
