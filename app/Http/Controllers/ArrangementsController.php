<?php

namespace App\Http\Controllers;

use App\Arrangement;
use App\Classroom;
use Illuminate\Http\Request;

class ArrangementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrangement_saving = Arrangement::make($request->all());
        foreach ((clone $arrangement_saving)->selectable_course->arrangements as $an_arrangement) {
            if (arrangement_conflict(clone $arrangement_saving, $an_arrangement)) {
                return response()->json([
                    'success' => false,
                    'message' => '与本课程其他时段的安排冲突'
                ]);
            }
        }
        if ((clone $arrangement_saving)->classroom) {
            foreach ((clone $arrangement_saving)->classroom->arrangements as $an_arrangement) {
                if (arrangement_conflict($an_arrangement, $arrangement_saving)) {
                    return response()->json([
                        'success' => false,
                        'message' => '教室与' . $an_arrangement->selectable_course->course->name . '课程冲突'
                    ]);
                }
            }
        }
        foreach ((clone $arrangement_saving)->selectable_course->students as $student) {
            foreach ($student->selectable_courses as $course) {
                foreach ($course->arrangements as $an_arrangement) {
                    if (arrangement_conflict(clone $arrangement_saving, $an_arrangement)) {
                        return response()->json([
                            'success' => false,
                            'message' => '与选择本课的学生'.$student->name.
                                '所选另一课程'.$an_arrangement->selectable_course->course->name.'冲突'
                        ]);
                    }
                }
            }
        }
        if ((clone $arrangement_saving)->selectable_course->teacher) {
            foreach ((clone $arrangement_saving)->selectable_course->teacher->selectable_courses as $course) {
                foreach ($course->arrangements as $an_arrangement) {
                    if (arrangement_conflict(clone $arrangement_saving, $an_arrangement)) {
                        return response()->json([
                            'success' => false,
                            'message' => '与讲授本课的老师' . (clone $arrangement_saving)->selectable_course->teacher->name .
                                '所教授的另一课程' . $an_arrangement->selectable_course->course->name . '冲突'
                        ]);
                    }
                }
            }
        }
        $arrangement_saving->save();
        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function show(Arrangement $arrangement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function edit(Arrangement $arrangement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arrangement $arrangement)
    {
        $arrangement_saving = Arrangement::make(array_merge($arrangement->toArray(), $request->all()));
        foreach ((clone $arrangement_saving)->selectable_course->arrangements as $an_arrangement) {
            if ($arrangement->id != $an_arrangement->id && arrangement_conflict(clone $arrangement_saving, $an_arrangement)) {
                return response()->json([
                    'success' => false,
                    'message' => '与本课程其他时段的安排冲突'
                ]);
            }
        }
        foreach ((clone $arrangement_saving)->classroom->arrangements as $an_arrangement) {
            if ($arrangement->id != $an_arrangement->id &&  arrangement_conflict($an_arrangement, $arrangement_saving)) {
                return response()->json([
                    'success' => false,
                    'message' => '教室与'.$an_arrangement->selectable_course->course->name.'课程冲突'
                ]);
            }
        }
        foreach ((clone $arrangement_saving)->selectable_course->students as $student) {
            foreach ($student->selectable_courses as $course) {
                foreach ($course->arrangements as $an_arrangement) {
                    if ($arrangement->id != $an_arrangement->id && arrangement_conflict(clone $arrangement_saving, $an_arrangement)) {
                        return response()->json([
                            'success' => false,
                            'message' => '与选择本课的学生'.$student->name.
                                '所选另一课程'.$an_arrangement->selectable_course->course->name.'冲突'
                        ]);
                    }
                }
            }
        }
        foreach ((clone $arrangement_saving)->selectable_course->teacher->selectable_courses as $course) {
            foreach ($course->arrangements as $an_arrangement) {
                if ($arrangement->id != $an_arrangement->id && arrangement_conflict(clone $arrangement_saving, $an_arrangement)) {
                    return response()->json([
                        'success' => false,
                        'message' => '与讲授本课的老师'.(clone $arrangement_saving)->selectable_course->teacher->name.
                            '所教授的另一课程'.$an_arrangement->selectable_course->course->name.'冲突'
                    ]);
                }
            }
        }
        $arrangement->update($request->all());
        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arrangement $arrangement)
    {
        $arrangement->delete();
        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }
}
