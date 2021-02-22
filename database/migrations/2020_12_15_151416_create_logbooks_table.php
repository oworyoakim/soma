<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('used_id');
            $table->unsignedBigInteger('instructor_id');
            $table->string('route')->nullable();
            $table->date('date_recorded');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('aircraft')->nullable();
            $table->string('landings')->nullable();
            $table->unsignedInteger('fight_type_id')->nullable();
            $table->float('duration')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
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
        Schema::dropIfExists('logbooks');
    }
}
