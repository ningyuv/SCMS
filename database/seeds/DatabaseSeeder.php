<?php

use App\Arrangement;
use App\Building;
use App\Classroom;
use App\Course;
use App\CourseStudent;
use App\CourseType;
use App\Department;
use App\Major;
use App\Semester;
use App\Student;
use App\Teacher;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (course_types_array() as $course_type) {
            CourseType::create(['name' => $course_type]);
        }
        foreach (department_names_array() as $department) {
            Department::create(['name' => $department]);
        }
        foreach (majors_array() as $major) {
            Major::create($major);
        }
        foreach (courses_array() as $course) {
            $course = array_merge($course, ['number' => $faker->unique()->numberBetween(1000,9999)]);
            Course::create($course);
        }
        foreach (teachers_array() as $teacher) {
            Teacher::create([
                'username' => $faker->unique()->firstName,
                'password' => '$2y$10$e09m/HOrwwQtK243oDu7Y.suOfU0jNrJd1rP38UiXjfK346we0ak.',
                'api_token' => Str::random(60),
                'name' => $teacher['name'],
                'gender' => $teacher['gender'],
                'number' => $faker->randomNumber(4),
            ]);
        }
        foreach (buildings_array() as $building) {
            Building::create($building);
        }
        foreach (classrooms_array() as $classroom) {
            Classroom::create($classroom);
        }
        for ($i=0;$i<models_size(Arrangement::class);++$i) {
            try {
                factory(\App\Arrangement::class)->create();
            } catch (Exception $exception) {}
        }
        for ($i=0;$i<models_size(Student::class);++$i) {
            factory(Student::class)->create();
        }
        foreach (CourseType::first()->selectable_courses as $course) {
            foreach (Student::all() as $student) {
                CourseStudent::create([
                    'student_id' => $student->id,
                    'selectable_course_id' => $course->id,
                ]);
            }
        }
        for ($i=0;$i<models_size(CourseStudent::class);++$i) {
            try {
                factory(\App\CourseStudent::class)->create();
            } catch (Exception $exception) {}
        }
        factory(App\Admin::class)->create();
    }
}
