<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('enrollment_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamp('exam_date');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->unsignedTinyInteger('num_questions');
            $table->unsignedTinyInteger('num_questions_answered');
            $table->unsignedTinyInteger('num_questions_passed');
            $table->float('pass_score',5,2)->unsigned();
            $table->float('score',5,2)->unsigned();
            $table->boolean('passed');
            $table->boolean('retakes')->default(0);
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
        Schema::dropIfExists('results');
    }
}
