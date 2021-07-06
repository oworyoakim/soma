<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->unsignedBigInteger('course_id');
            $table->unsignedTinyInteger('duration')->comment('Duration of the exam in minutes');
            $table->unsignedTinyInteger('num_questions')->comment('The number of questions to be answered');
            $table->float('pass_score', 5, 2)->unsigned()->comment('Pass score in percentage');
            $table->tinyInteger('maximum_attempts')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('exams');
    }
}
