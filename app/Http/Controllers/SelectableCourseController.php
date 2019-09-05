<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStudent;
use App\CourseType;
use App\SelectableCourse;
use App\Student;
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
        if (\request()->course_type_id && \request()->course_type_id != 0) {
            array_push($arr, ['course_type_id', \request()->course_type_id]);
        }
        $builder = SelectableCourse::with(
            'course.department',
            'arrangements.classroom.building',
            'arrangements.selectable_course.course',
            'teacher',
            'students',
            'course_type',
            'classes'
        )->where($arr)
            ->whereHas('course', function ($query) {
                $query->where('name', 'like', '%' . \request()->course_name . '%');
            })
            ->whereHas('course', function ($query) {
                $query->where('number', 'like', '%' . \request()->course_number . '%');
            });
        if (\request()->classes_id && \request()->classes_id != 0) {
            $builder = $builder->where(function ($query) {
                $query->where('classes_id', \request()->classes_id)->orWhere('course_type_id', 3);
            });
        }
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
        $course = SelectableCourse::create($request->selectable_course);
        if ($request->selectable_course['course_type_id'] == 1) {
            foreach (Student::where('classes_id', $course->classes_id)->get() as $student) {
                CourseStudent::create([
                    'student_id' => $student->id,
                    'selectable_course_id' => $course->id
                ]);
            }
        }
        return response()->json([
            'success' => true,
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
        $course_saving = clone $selectableCourse;
        foreach (CourseType::first()->selectable_courses->where('classes_id', $request->selectable_course['classes_id']) as $that_course) {
            foreach ($that_course->arrangements as $arrangement1) {
                foreach ($course_saving->arrangements as $arrangement2) {
                    if ($course_saving->id != $that_course->id && arrangement_conflict($arrangement1, $arrangement2)) {
                        return response()->json([
                            'success' => false,
                            'message' => '与另一必修课 '.$that_course->course->name.'('.$that_course->teacher->name.') 冲突'
                        ]);
                    }
                }
            }
        }
        if ($request->selectable_course['course_type_id'] == 1) {
            foreach (Student::where('classes_id', $request->selectable_course['classes_id'])->get() as $student) {
                if (!$student->selectable_courses->contains('id', $selectableCourse->id)) {
                    CourseStudent::create([
                        'student_id' => $student->id,
                        'selectable_course_id' => $selectableCourse->id
                    ]);
                }
            }
        }
        if ($request->selectable_course['course_type_id'] == 1 || $request->selectable_course['course_type_id'] == 2) {
            foreach (Student::where('classes_id', $course_saving->classes_id)->get() as $student) {
                $course_student = CourseStudent::where([
                    'student_id' => $student->id,
                    'selectable_course_id' => $course_saving->id,
                ]);
                if ($course_student) {
                    $course_student->delete();
                }
            }
        }
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
