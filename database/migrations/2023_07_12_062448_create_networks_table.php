<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            //'user_id' は 'usersテーブル' の 'id' を参照する外部キーです
            $table->string('title',50);
            $table->string('keyword',50);
            $table->string('graph');
            $table->string('sort',50);
            $table->string('component',50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('networks');
    }
};
