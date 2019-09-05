<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Arrangement;
use App\Classroom;
use App\SelectableCourse;
use Faker\Generator as Faker;

$factory->define(Arrangement::class, function (Faker $faker) {
    $selectable_course = random_item(SelectableCourse::class);
    $start = 1;
    $end = random_int(0,1)?8:16;
    $delta = 2;
    $start_week = random_int(0,3)*2+1;

    $weeks = min($start,$end).'-'.max($start,$end);
    $sessions = random_int(1,5).':'.$start_week.'-'.($start_week+$delta);

    $classroom_id = random_item(\App\Classroom::class, true);
    $arrangement_saving = Arrangement::make([
        'selectable_course_id' => $selectable_course,
        'classroom_id' => $classroom_id,
        'weeks' => $weeks,
        'sessions' => $sessions,
    ]);
    try {
        foreach ((clone $arrangement_saving)->selectable_course->arrangements as $arrangement) {
            if (arrangement_conflict(clone $arrangement_saving, $arrangement)) {
                throw new Exception('self_conflict');
            }
        }
        foreach (Classroom::find($classroom_id)->arrangements as $arrangement) {
            if (arrangement_conflict($arrangement, $arrangement_saving)) {
                throw new Exception('classroom_conflict');
            }
        }
        foreach ((clone $arrangement_saving)->selectable_course->students as $student) {
            foreach ($student->selectable_courses as $course) {
                foreach ($course->arrangements as $arrangement) {
                    if (arrangement_conflict(clone $arrangement_saving, $arrangement)) {
                        throw new Exception('students_courses_conflict');
                    }
                }
            }
        }
        foreach ((clone $arrangement_saving)->selectable_course->teacher->selectable_courses as $course) {
            foreach ($course->arrangements as $arrangement) {
                if (arrangement_conflict(clone $arrangement_saving, $arrangement)) {
                    throw new Exception('teacher_courses_conflict');
                }
            }
        }
    } catch (Exception $e) {
        SelectableCourse::find($selectable_course)->delete();
        throw $e;
    }

    return $arrangement_saving->toArray();
});
