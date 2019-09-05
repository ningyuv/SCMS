<?php

namespace App\Http\Controllers;

use App\SelectableCourse;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinishController extends Controller
{
    public function get(Request $request) {
        return Setting::first()->last_finished_at;
    }

    public function finish(Request $request) {
        if (!Setting::first()){
            Setting::create([
                'last_finished_at' => Carbon::now()
            ]);
        }
        Setting::first()->update([
            'last_finished_at' => Carbon::now()
        ]);
        if ($request->leave_data) {
        }
        else {
            foreach (SelectableCourse::all() as $course) {
                $course->delete();
            }
        }
    }
}
