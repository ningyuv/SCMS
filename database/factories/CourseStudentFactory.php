<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Arrangement;
use App\Classroom;
use App\CourseStudent;
use App\SelectableCourse;
use Faker\Generator as Faker;

$factory->define(CourseStudent::class, function (Faker $faker) {
    $student = App\Student::find(random_item(\App\Student::class));
    $selectable_course = random_item(SelectableCourse::class,true, $student->classes_id);

    foreach ($student->selectable_courses as $course) {
        if (courses_conflict(SelectableCourse::find($selectable_course), $course)) {
            throw new Exception('courses_conflicted');
        }
    }
    if (SelectableCourse::find($selectable_course)->students->count() >= SelectableCourse::find($selectable_course)->max_num) {
        throw new Exception('course_full');
    }

    return [
        'student_id' => $student,
        'selectable_course_id' => $selectable_course,
    ];
});
