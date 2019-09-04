<?php

namespace App\Http\Controllers;

use App\SelectableCourse;
use Illuminate\Http\Request;

class SelectableCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr = [];
        if (\request()->teacher_id && \request()->teacher_id != 0) {
            array_push($arr, ['teacher_id', \request()->teacher_id]);
        }
        if (\request()->credit && \request()->credit != 0) {
            array_push($arr, ['credit', \request()->credit]);
        }
        $builder = SelectableCourse::with(
            'course.department',
            'arrangements.classroom.building',
            'arrangements.selectable_course.course',
            'teacher',
            'students'
        )->where($arr)
            ->whereHas('course', function ($query) {
                $query->where('name', 'like', '%' . \request()->course_name . '%');
            })
            ->whereHas('course', function ($query) {
                $query->where('number', 'like', '%' . \request()->course_number . '%');
            });
        if (\request()->department_id && \request()->department_id != 0) {
            $builder = $builder
                ->whereHas('course', function ($query) {
                    $query->where('department_id', \request()->department_id);
            });
        }
        return response()->json($builder->get());
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SelectableCourse::create($request->selectable_course);
        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SelectableCourse $selectableCourse
     * @return \Illuminate\Http\Response
     */
    public function show(SelectableCourse $selectableCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\SelectableCourse $selectableCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(SelectableCourse $selectableCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SelectableCourse $selectableCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SelectableCourse $selectableCourse)
    {
        $selectableCourse->update($request->selectable_course);
        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SelectableCourse $selectableCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(SelectableCourse $selectableCourse)
    {
        $selectableCourse->delete();
        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }
}
