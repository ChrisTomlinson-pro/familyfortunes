<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FirstMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string("name");
            $table->boolean("is_broadcasting")->default(false);
            $table->timestamps();
        });

        Schema::create('question', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->mediumText("text");
            $table->unsignedBigInteger('quiz_id');
            $table->boolean('is_broadcasting')->default(false);
            $table->foreign('quiz_id')->references('id')->on('quiz')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->mediumText("text");
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('question')->cascadeOnDelete();
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
        Schema::dropIfExists('answer');
        Schema::dropIfExists('quiz');
        Schema::dropIfExists('question');
    }
}
