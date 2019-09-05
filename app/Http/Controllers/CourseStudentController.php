<?php

namespace App\Http\Controllers;

use App\CourseStudent;
use App\SelectableCourse;
use App\Student;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(CourseStudent::with('student', 'selectable_course')->get());
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
        $selectable_course = SelectableCourse::find($request->selectable_course_id);
        $student = Student::find($request->student_id);

        foreach ($student->selectable_courses as $course) {
            if (courses_conflict($selectable_course, $course)) {
                return response()->json([
                    'success' => false,
                    'message' => '与课程 '.$course->id.' '.$course->course->name.' ('.$course->teacher->name.')冲突'
                ]);
            }
        }

        if ($selectable_course->students->count() >= $selectable_course->max_num) {
            return response()->json([
                'success' => false,
                'message' => '课程人满'
            ]);
        }

        if ($selectable_course->course_type_id == 1 &&
            $student->selectable_courses
                ->where('course_type_id','1')
                ->pluck('course')
                ->pluck('credit')
                ->sum()
            + $selectable_course->course->credit > $student->classes->compulsory_credit) {
            return response()->json([
                'success' => false,
                'message' => '必修学分超限'
            ]);
        }
        if ($selectable_course->course_type_id == 2 &&
            $student->selectable_courses
                ->where('course_type_id','2')
                ->pluck('course')
                ->pluck('credit')
                ->sum()
            + $selectable_course->course->credit > $student->classes->restriction_credit) {
            return response()->json([
                'success' => false,
                'message' => '限选学分超限'
            ]);
        }
        if ($selectable_course->course_type_id == 3 &&
            $student->selectable_courses
                ->where('course_type_id','3')
                ->pluck('course')
                ->pluck('credit')
                ->sum()
            + $selectable_course->course->credit > $student->classes->optional_credit) {
            return response()->json([
                'success' => false,
                'message' => '任选学分超限'
            ]);
        }

        return CourseStudent::create([
            'student_id' => $request->student_id,
            'selectable_course_id' => $request->selectable_course_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function show(CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseStudent $courseStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseStudent  $courseStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseStudent $courseStudent)
    {
        $courseStudent->delete();
        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
