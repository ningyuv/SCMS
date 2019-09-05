<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseType;
use App\SelectableCourse;
use App\Teacher;
use Faker\Generator as Faker;

$factory->define(SelectableCourse::class, function (Faker $faker) {

    $teacher = Teacher::find(random_item(\App\Teacher::class, true));
    $course_saving = App\SelectableCourse::make([
        'course_id' => random_item(\App\Course::class, true),
        'teacher_id' => $teacher->id,
        'max_num' => random_int(16,20)*10,
        'course_type_id' => random_item(CourseType::class, true)
    ]);
    foreach ($teacher->selectable_courses as $course) {
        if (courses_conflict(clone $course_saving, $course)) {
            throw new Exception('courses_conflicted');
        }
    }

    return $course_saving->toArray();
});
