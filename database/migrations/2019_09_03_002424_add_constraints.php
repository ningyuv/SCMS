<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('major_id')
                ->references('id')
                ->on('majors')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
        Schema::table('classrooms', function (Blueprint $table) {
            $table->foreign('building_id')
                ->references('id')
                ->on('buildings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        Schema::table('majors', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
        Schema::table('course_student', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('selectable_course_id')
                ->references('id')
                ->on('selectable_courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        Schema::table('selectable_courses', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('no action')
                ->onDelete('no action');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
        Schema::table('arrangements', function (Blueprint $table) {
            $table->foreign('selectable_course_id')
                ->references('id')
                ->on('selectable_courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('classroom_id')
                ->references('id')
                ->on('classrooms')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('major_id');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign('department_id');
        });
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign('building_id');
        });
        Schema::table('majors', function (Blueprint $table) {
            $table->dropForeign('department_id');
        });
        Schema::table('course_student', function (Blueprint $table) {
            $table->dropForeign('student_id');
            $table->dropForeign('selectable_course_id');
        });
        Schema::table('selectable_courses', function (Blueprint $table) {
            $table->dropForeign('course_id');
            $table->dropForeign('teacher_id');
            $table->dropForeign('classroom_id');
        });
    }
}
