<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('host_id');
            $table->string('meeting_id');
            $table->string('meeting_password');
            $table->string('meeting_uuid')->nullable();
            $table->text('join_url')->nullable();
            $table->text('start_url')->nullable();
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedInteger('duration');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->enum('type',['meeting','webinar'])->default('meeting');
            $table->enum('status',['scheduled','ongoing','ended','missed','archived'])->default('scheduled');
            $table->text('remarks')->nullable();
            $table->text('settings')->nullable();
            $table->string('recorded_video_path')->nullable();
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
        Schema::dropIfExists('classrooms');
    }
}
