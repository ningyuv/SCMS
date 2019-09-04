<?php

use App\Arrangement;
use App\CourseStudent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<models_size(Arrangement::class);++$i) {
            try {
                factory(\App\Arrangement::class)->create();
            } catch (Exception $exception) {}
        }
        for ($i=0;$i<models_size(CourseStudent::class);++$i) {
            try {
                factory(\App\CourseStudent::class)->create();
            } catch (Exception $exception) {}
        }
        factory(App\Admin::class)->create();
    }
}
