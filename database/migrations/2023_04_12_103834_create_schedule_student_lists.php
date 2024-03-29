<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleStudentLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_student_lists', function (Blueprint $table) {
            $table->id('schedule_student_list_id');

            $table->string('student_id')->nullable();

            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->string('student_lname')->nullable();
            $table->string('student_fname')->nullable();
            $table->string('student_mname')->nullable();
            $table->string('student_suffix')->nullable();
            $table->string('student_sex')->nullable();
            $table->string('student_contact_no')->nullable();

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
        Schema::dropIfExists('schedule_student_lists');
    }
}
