<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('软件名');
            $table->text('description')->comment('软件描述');
            $table->text('cracks')->comment('破解信息');
            $table->string('icon_path')->comment('图标路径');
            $table->integer('mac_id')->nullable()->comment('Mac 文件外键');
            $table->integer('win_id')->nullable()->comment('Win 文件外键');
            $table->integer('rank')->default(0)->comment('排序');
            $table->boolean('enable')->default(true)->comment('是否上架');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
