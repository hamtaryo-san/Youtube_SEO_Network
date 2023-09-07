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
        Schema::create('network_tag', function (Blueprint $table) {
            $table->foreignId('network_id')->constrained('networks');
            $table->foreignId('tag_id')->constrained('tags');
            $table->primary(['network_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('network_tag');
    }
};