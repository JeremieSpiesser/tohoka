<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance', function (Blueprint $table) {
            $table->unsignedBigInteger('id'); // We don't want id here because it's autoincrement and we only want 6 random digits id
            $table->unsignedBigInteger('master');
            $table->foreign('master')
                  ->references('id')
                  ->on('users');
            $table->unsignedBigInteger('idQuizz');
            $table->foreign('idQuizz')
                  ->references('id')
                  ->on('quizzs');
            $table->integer('currentQuestion')  // -1 means not started
                  ->default(-1);                // (-2 means finished ?)
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
        Schema::dropIfExists('instance');
    }
}
