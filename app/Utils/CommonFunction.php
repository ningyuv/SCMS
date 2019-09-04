<?php

use App\CourseStudent;
use App\SelectableCourse;
use App\Teacher;

function random_item($class, $strict=false){
    $size = models_size($class);
    $instance = $class::find(random_int(1, $size));
    if ($strict) {
        $instance = $class::all()->random();
    }
    else if (!$instance) {
        $instance = factory($class)->create();
    }
    return $instance->id;
}
function number_collection() {
    $arr = [];
    for ($i=1;$i<=models_size(SelectableCourse::class);++$i) {
        array_push($arr, $i);
    }
    return collect($arr);
}
function models_size($class='') {
    if ($class == CourseStudent::class) {
        return 100;
    }
    if ($class == SelectableCourse::class) {
        $size=20;
    }
    if ($class == Teacher::class) {
        $size=5;
    }
    return 50;
}
function numbers_str_to_array($weeks_str) {
    $weeks = [];
    foreach (explode(',', $weeks_str) as $week_piece) {
        $during = explode('-', $week_piece);
        if (count($during) == 2) {
            for ($i=intval($during[0]);$i<=intval($during[1]);++$i){
                array_push($weeks, $i);
            }
        }
        else{
            array_push($weeks, intval($during[0]));
        }
    }
    return $weeks;
}
function days_to_array($days_sessions) {
    $days = [];
    foreach (explode('&', $days_sessions) as $day_sessions) {
        array_push($days, intval(explode(':', $day_sessions)[0]));
    }
    return $days;
}
function one_day_sessions($day, $days_sessions) {
    $sessions = [];
    foreach (explode('&', $days_sessions) as $day_sessions) {
        if (intval(explode(':', $day_sessions)[0])==$day) {
            $sessions = array_merge($sessions, numbers_str_to_array(explode(':', $days_sessions)[1]));
        }
    }
    return $sessions;
}
function courses_conflict($course1, $course2) {
    foreach ($course1->arrangements as $arrangement1){
        foreach ($course2->arrangements as $arrangement2){
            if (arrangement_conflict($arrangement1, $arrangement2)){
                return true;
            }
        }
    }
    return false;
}
function arrangement_conflict($arrangement1, $arrangement2) {
    if (intersect_nums_str($arrangement1->weeks, $arrangement2->weeks)) {
        if ($days=intersect_days_str($arrangement1->sessions, $arrangement2->sessions)) {
            foreach ($days as $day) {
                if (intersect_one_day_sessions($day, $arrangement1->sessions, $arrangement2->sessions)) {
                    return true;
                }
            }
        }
    }
    return false;
}
function intersect_nums_str($nums1, $nums2) {
    return array_values(array_intersect(numbers_str_to_array($nums1), numbers_str_to_array($nums2)));
}
function intersect_days_str($days1, $days2) {
    return array_values(array_intersect(days_to_array($days1), days_to_array($days2)));
}
function intersect_one_day_sessions($day, $day_sessions1, $day_sessions2) {
    return array_intersect(one_day_sessions($day, $day_sessions1), one_day_sessions($day, $day_sessions2));
}
function classroom_conflict($arrangement1, $arrangement2){

}
