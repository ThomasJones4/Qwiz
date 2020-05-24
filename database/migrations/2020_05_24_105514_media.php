<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Media extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('media', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('question_id')->unsigned()->index();
          $table->foreign('question_id')->references('id')->on('questions');
          $table->string('url')->nullable();
          $table->string('type')->nullable();
          $table->string('extension')->nullable();
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
        //
    }
}
