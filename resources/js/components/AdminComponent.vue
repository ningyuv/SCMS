<template>
    <div class="row">
        <div class="col-2">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active"
                   id="list-tab-student-list" data-toggle="list" href="#list-tab-student" role="tab"
                   aria-controls="tab-student">管理学生信息</a>
                <a class="list-group-item list-group-item-action"
                   id="list-tab-teacher-list" data-toggle="list" href="#list-tab-teacher" role="tab"
                   aria-controls="tab-teacher">管理教师信息</a>
                <a class="list-group-item list-group-item-action"
                   id="list-tab-course-list" data-toggle="list" href="#list-tab-course" role="tab"
                   aria-controls="tab-course">管理课程信息</a>
                <a class="list-group-item list-group-item-action"
                   id="list-tab-selectable_course-list" data-toggle="list" href="#list-tab-selectable_course" role="tab"
                   aria-controls="tab-selectable_course">课程编排</a>
                <a class="list-group-item list-group-item-action p-0"
                   id="list-basic-list" data-toggle="list" :href="`#${sub_tab}`" role="tab"
                   aria-controls="basic">
                    <div data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="padding: 0.75rem 1.25rem">基础信息维护</div>
                </a>
                <div id="collapseOne" class="collapse collapsed mt-2 mb-2" aria-labelledby="headingOne" data-parent="#list-tab">
                    <div class="list-group ml-4" id="list-sub-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active"
                           id="list-tab-building-list" data-toggle="list" href="#list-tab-building" role="tab"
                           aria-controls="tab-building" @click="sub_tab='list-tab-building'">管理教学楼信息</a>
                        <a class="list-group-item list-group-item-action"
                           id="list-tab-classroom-list" data-toggle="list" href="#list-tab-classroom" role="tab"
                           aria-controls="tab-classroom" @click="sub_tab='list-tab-classroom'">管理教室信息</a>
                        <a class="list-group-item list-group-item-action"
                           id="list-tab-department-list" data-toggle="list" href="#list-tab-department" role="tab"
                           aria-controls="tab-department" @click="sub_tab='list-tab-department'">管理学院信息</a>
                        <a class="list-group-item list-group-item-action"
                           id="list-tab-major-list" data-toggle="list" href="#list-tab-major" role="tab"
                           aria-controls="tab-major" @click="sub_tab='list-tab-major'">管理专业信息</a>
                    </div>
                </div>
                <a class="list-group-item list-group-item-action"
                   id="list-profile-list" data-toggle="list" href="#list-profile" role="tab"
                   aria-controls="profile">个人信息</a>
            </div>
            <div class="mt-2 justify-content-center">
                <button class="btn btn-primary w-100 btn-lg" style="font-size: 1rem" @click="finish">本次选课完成，开始下次选课</button>
                <div class="row align-items-center m-auto" style="min-height: 2rem;">
                    <input type="checkbox" id="checkbox" checked>
                    <div>保留本次选课信息</div>
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active"
                     id="list-tab-student" role="tabpanel" aria-labelledby="list-tab-student-list">
                    <div class="card">
                        <h5 class="card-header">管理学生信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <input name="student_name" id="student_name" class="form-control" type="text"
                                           placeholder="输入姓名">
                                </div>
                                <div class="col-md-2">
                                    <input name="student_number" id="student_number" class="form-control" type="text"
                                           placeholder="输入学号">
                                </div>
                                <div class="col-md-3">
                                    <select name="department" id="department_student" class="form-control">
                                        <option value="0">--选择院系--</option>
                                        <option :value="department.id" v-for="department in departments">{{
                                            department.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary form-control"
                                            @click="update_students">查询
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#studentModel"
                                            @click="change_model_state(false)">添加
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">学号</th>
                                    <th scope="col">姓名</th>
                                    <th scope="col">院系</th>
                                    <th scope="col">专业</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(student,index) in students">
                                    <th>{{ student.number }}</th>
                                    <th>{{ student.name }}</th>
                                    <th>{{ student.major?student.major.department.name:'' }}</th>
                                    <th>{{ student.major?student.major.name:'' }}</th>
                                    <th>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#studentModel"
                                                @click="change_current_student(index)">修改
                                        </button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_student(student.id)">删除</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="studentModel" tabindex="-1" role="dialog"
                                 aria-labelledby="studentModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="studentModelTitle">编辑学生信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label for="username"
                                                               class="col-md-3 col-form-label text-md-right">用户名</label>

                                                        <div class="col">
                                                            <input id="username" type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_student.username"
                                                                   autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="number"
                                                               class="col-md-3 col-form-label text-md-right">学号</label>

                                                        <div class="col">
                                                            <input id="number" type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_student.number">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-3 col-form-label text-md-right">姓名</label>

                                                        <div class="col">
                                                            <input id="name" type="text"
                                                                   class="form-control"
                                                                   name="name"
                                                                   v-model:value="current_student.name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">性别</label>

                                                        <div class="col">
                                                            <select id="gender"
                                                                    class="form-control"
                                                                    name="gender"
                                                                    v-model:value="current_student.gender">
                                                                <option value="0">--选择性别--</option>
                                                                <option value="1">男</option>
                                                                <option value="2">女</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="enrollment_year"
                                                               class="col-md-3 col-form-label text-md-right">班级</label>

                                                        <div class="col">
                                                            <input id="enrollment_year" type="text"
                                                                   class="form-control"
                                                                   :value="current_student.classes?current_student.classes.name:''"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="department_id"
                                                               class="col-md-3 col-form-label text-md-right">院系</label>

                                                        <div class="col">
                                                            <select name="department" id="department_id"
                                                                    class="form-control"
                                                                    :value="current_student.major?current_student.major.department_id:0"
                                                                    disabled>
                                                                <option value="0">--选择院系--</option>
                                                                <option :value="department.id"
                                                                        v-for="department in departments">{{
                                                                    department.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="major"
                                                               class="col-md-3 col-form-label text-md-right">专业</label>

                                                        <div class="col">
                                                            <select name="major" id="major" class="form-control"
                                                                    v-model:value="current_student.major_id">
                                                                <option value="0">--选择专业--</option>
                                                                <option :value="major.id"
                                                                        v-for="major in majors">
                                                                    {{ major.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="password"
                                                               class="col-md-3 col-form-label text-md-right">密码</label>

                                                        <div class="col">
                                                            <input id="password" type="text" placeholder="不更改"
                                                                   v-model:value="current_student.password"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary" @click="update_student_info">
                                                保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-tab-teacher" role="tabpanel" aria-labelledby="list-tab-teacher-list">
                    <div class="card">
                        <h5 class="card-header">管理教师信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <input name="teacher_name" id="teacher_name" class="form-control" type="text"
                                           placeholder="输入姓名">
                                </div>
                                <div class="col-md-2">
                                    <input name="teacher_number" id="teacher_number" class="form-control" type="text"
                                           placeholder="输入工号">
                                </div>
                                <div class="col-md-3">
                                    <select name="gender" id="gender_teacher" class="form-control">
                                        <option value="0">--选择性别--</option>
                                        <option value="1">男</option>
                                        <option value="2">女</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary form-control"
                                            @click="update_teachers">查询
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#teacherModel"
                                            @click="change_model_state(false)">添加
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">工号</th>
                                    <th scope="col">姓名</th>
                                    <th scope="col">性别</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(teacher, index) in teachers">
                                    <th>{{ teacher.number }}</th>
                                    <th>{{ teacher.name }}</th>
                                    <th>{{ teacher.gender==1?'男':'女' }}</th>
                                    <th>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#teacherModel"
                                                @click="change_current_teacher(index)">修改</button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_teacher(teacher.id)">删除</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="teacherModel" tabindex="-1" role="dialog"
                                 aria-labelledby="teacherModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="teacherModelTitle">编辑教师信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label for="username"
                                                               class="col-md-3 col-form-label text-md-right">用户名</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_teacher.username"
                                                                   autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="number"
                                                               class="col-md-3 col-form-label text-md-right">工号</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_teacher.number"
                                                                   autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-3 col-form-label text-md-right">姓名</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="name"
                                                                   v-model:value="current_teacher.name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">性别</label>

                                                        <div class="col">
                                                            <select
                                                                class="form-control"
                                                                name="gender"
                                                                v-model:value="current_teacher.gender">
                                                                <option value="0">选择性别</option>
                                                                <option value="1">男</option>
                                                                <option value="2">女</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="password"
                                                               class="col-md-3 col-form-label text-md-right">密码</label>

                                                        <div class="col">
                                                            <input type="text" placeholder="不更改"
                                                                   v-model:value="current_teacher.password"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary" @click="update_teacher_info">
                                                保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-tab-course" role="tabpanel" aria-labelledby="list-tab-course-list">
                    <div class="card">
                        <h5 class="card-header">管理课程信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#courseModel"
                                            @click="change_model_state(false)">添加
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">课程编号</th>
                                    <th scope="col">课程名称</th>
                                    <th scope="col">学分</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(course,index) in courses">
                                    <th>{{ course.number }}</th>
                                    <th>{{ course.name }}</th>
                                    <th>{{ course.credit }}</th>
                                    <th>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#courseModel"
                                                @click="change_current_course(index)">修改</button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_course(course.id)">删除
                                        </button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="courseModel" tabindex="-1" role="dialog"
                                 aria-labelledby="courseModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="courseModelTitle">编辑课程信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label for="number"
                                                               class="col-md-3 col-form-label text-md-right">课程号</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_course.number"
                                                                   autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-3 col-form-label text-md-right">课程名</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="name"
                                                                   v-model:value="current_course.name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">学分</label>

                                                        <div class="col">
                                                            <input type="number"
                                                                   class="form-control"
                                                                   name="gender"
                                                                   v-model:value="current_course.credit">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="department_id"
                                                               class="col-md-3 col-form-label text-md-right">院系</label>

                                                        <div class="col">
                                                            <select name="department"
                                                                    class="form-control"
                                                                    v-model:value="current_course.department_id">
                                                                <option value="0">--选择院系--</option>
                                                                <option :value="department.id"
                                                                        v-for="department in departments">{{
                                                                    department.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="update_course_info">保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-tab-selectable_course" role="tabpanel" aria-labelledby="list-tab-selectable_course-list">
                    <div class="card">
                        <h5 class="card-header">课程编排</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="teacher" id="teacher" class="form-control">
                                        <option value="0">--教师姓名--</option>
                                        <option :value="teacher.id" v-for="teacher in teachers">{{ teacher.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="department" id="department" class="form-control">
                                        <option value="0">--开课院系--</option>
                                        <option :value="department.id" v-for="department in departments">{{
                                            department.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input name="course_name" id="course_name" class="form-control" type="text"
                                           placeholder="课程名称">
                                </div>
                                <div class="col-md-2">
                                    <input name="course_number" id="course_number" class="form-control" type="text"
                                           placeholder="课程编号">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary form-control"
                                            @click="update_selectable_courses">查询
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#selectable_courseModel"
                                            @click="change_model_state(false)">添加
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">编号</th>
                                    <th scope="col">课程编号</th>
                                    <th scope="col">课程性质</th>
                                    <th scope="col">课程名称</th>
                                    <th scope="col">上课时间地点</th>
                                    <th scope="col">教师</th>
                                    <th scope="col">选课人数</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="course in selectable_courses" v-if="new Date(course.updated_at) >=  finish_date">
                                    <th>{{ course.id }}</th>
                                    <th>{{ course.course.number }}</th>
                                    <th>{{ course.course_type.name }}</th>
                                    <th>{{ course.course.name }}</th>
                                    <th>
                                        <div v-for="arrangement in course.arrangements">
                                            {{ arrangement.weeks }}周 星期{{ arrangement.sessions }}节 {{ arrangement.classroom?arrangement.classroom.building.name:'' }} {{ arrangement.classroom?arrangement.classroom.name:'' }}
                                        </div>
                                    </th>
                                    <th>{{ course.teacher?course.teacher.name:'' }}</th>
                                    <th>{{ course.students.length }}/{{ course.max_num }}</th>
                                    <th>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#selectable_courseModel"
                                        @click="change_current_selectable_course(course)">修改</button>
                                    </th>
                                    <th><button class="btn btn-danger" @click="delete_selectable_course(course)">删除</button></th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="selectable_courseModel" tabindex="-1" role="dialog"
                                 aria-labelledby="selectable_courseModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="selectable_courseModelTitle">编辑排课信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">教师</label>

                                                        <div class="col">
                                                            <select name="teacher_id" class="form-control" v-model:value="current_selectable_course.teacher_id">
                                                                <option value="0">--选择教师--</option>
                                                                <option :value="teacher.id" v-for="teacher in teachers">
                                                                    {{ teacher.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">课程</label>

                                                        <div class="col">
                                                            <select name="course_id" class="form-control" v-model:value="current_selectable_course.course_id">
                                                                <option value="0">--选择课程--</option>
                                                                <option :value="course.id" v-for="course in courses">
                                                                    {{ course.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">课程性质</label>

                                                        <div class="col">
                                                            <select name="course_id" class="form-control" v-model:value="current_selectable_course.course_type_id">
                                                                <option value="0">--选择课程性质--</option>
                                                                <option :value="course_type.id" v-for="course_type in course_types">
                                                                    {{ course_type.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="gender"
                                                               class="col-md-3 col-form-label text-md-right">班级</label>

                                                        <div class="col">
                                                            <select name="course_id" class="form-control" v-model:value="current_selectable_course.classes_id">
                                                                <option value="0">--选择班级--</option>
                                                                <option :value="classes.id" v-for="classes in classess">
                                                                    {{ classes.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label text-md-right">最多人数</label>

                                                        <div class="col">
                                                            <input name="course_id" class="form-control" v-model:value="current_selectable_course.max_num">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row justify-content-center">
                                                        <h5>排课信息</h5>
                                                    </div>
                                                    <ul class="list-group text-center">
                                                        <li class="list-group-item row" v-for="arrangement in current_selectable_course.arrangements">
                                                            <span v-if="current_arrangement_id==arrangement.id">
                                                                <input type="text" v-model:value="current_arrangement_week_start" style="width: 2rem">
                                                                -
                                                                <input type="text" v-model:value="current_arrangement_week_end" style="width: 2rem">
                                                            </span>
                                                            <span v-else>{{ arrangement.weeks }}</span>周
                                                            <span v-if="current_arrangement_id==arrangement.id">
                                                                星期
                                                                <input type="text" v-model:value="current_arrangement_day" style="width: 2rem">
                                                                第
                                                                <input type="text" v-model:value="current_arrangement_session_start" style="width: 2rem">
                                                                -
                                                                <input type="text" v-model:value="current_arrangement_session_end" style="width: 2rem">
                                                                节
                                                            </span>
                                                            <span v-else>星期{{ arrangement.sessions }}节</span>

                                                            <select v-if="current_arrangement_id==arrangement.id" name="classroom_id" v-model:value="current_arrangement_classroom_id" class="form-control col-md-5 d-inline">
                                                                <option value="0">--选择教室--</option>
                                                                <option :value="classroom.id" v-for="classroom in classrooms">{{ classroom.building.name }} {{ classroom.name }}</option>
                                                            </select>
                                                            <span v-else>{{ arrangement.classroom?arrangement.classroom.building.name:'' }} {{ arrangement.classroom?arrangement.classroom.name:'' }}</span>
                                                            <button class="btn btn-danger btn-sm col-md-1 float-right" @click="delete_arrangement(arrangement.id)">删除</button>
                                                            <button class="btn btn-primary btn-sm col-md-1 float-right mr-2"
                                                                    @click="change_editing_index_or_update(arrangement)">
                                                                {{current_arrangement_id==arrangement.id?'保存':'编辑'}}
                                                            </button>
                                                        </li>
                                                        <li class="list-group-item row">
                                                            <span>
                                                                <input type="text" v-model:value="new_arrangement_week_start" style="width: 2rem">
                                                                -
                                                                <input type="text" v-model:value="new_arrangement_week_end" style="width: 2rem">
                                                            </span> 周
                                                            <span>
                                                                星期
                                                                <input type="text" v-model:value="new_arrangement_day" style="width: 2rem">
                                                                第
                                                                <input type="text" v-model:value="new_arrangement_session_start" style="width: 2rem">
                                                                -
                                                                <input type="text" v-model:value="new_arrangement_session_end" style="width: 2rem">
                                                                节
                                                            </span>

                                                            <select name="classroom_id" v-model:value="new_arrangement_classroom_id" class="form-control col-md-5 d-inline">
                                                                <option value="0">--选择教室--</option>
                                                                <option :value="classroom.id" v-for="classroom in classrooms">{{ classroom.building.name }} {{ classroom.name }}</option>
                                                            </select>
                                                            <button class="btn btn-primary btn-sm col-md-1 float-right"
                                                                    @click="add_arrangement()">
                                                                添加
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="update_selectable_course_info">保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-tab-building" role="tabpanel" aria-labelledby="list-tab-building-list">
                    <div class="card">
                        <h5 class="card-header">管理教学楼信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#buildingModel" @click="current_building={}">添加
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">编号</th>
                                    <th scope="col">名称</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="building in buildings">
                                    <th>{{ building.id }}</th>
                                    <th v-if="current_building.id==building.id">
                                        <input type="text" class="form-control text-center" v-model:value="current_building.name">
                                    </th>
                                    <th v-else>{{ building.name }}</th>
                                    <th>
                                        <button class="btn btn-primary" @click="update_building_info()" v-if="current_building.id==building.id">保存</button>
                                        <button class="btn btn-primary" @click="change_current_building(building)" v-else>修改</button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_building(building)">删除</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="buildingModel" tabindex="-1" role="dialog"
                                 aria-labelledby="buildingModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="buildingModelTitle">添加教学楼信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label for="number"
                                                               class="col-md-3 col-form-label text-md-right">教学楼名称</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_building.name"
                                                                   autofocus>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="add_building_info">保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                <div class="tab-pane fade"
                     id="list-tab-classroom" role="tabpanel" aria-labelledby="list-tab-classroom-list">
                    <div class="card">
                        <h5 class="card-header">管理教室信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#classroomModel" @click="current_classroom={building_id:0}">添加</button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">编号</th>
                                    <th scope="col">名称</th>
                                    <th scope="col">所在教学楼</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="classroom in classrooms">
                                    <th>{{ classroom.id }}</th>
                                    <th v-if="current_classroom.id==classroom.id">
                                        <input type="text" class="form-control text-center" v-model:value="current_classroom.name">
                                    </th>
                                    <th v-else>{{ classroom.name }}</th>
                                    <th v-if="current_classroom.id==classroom.id">
                                        <select name="building_id" v-model:value="current_classroom.building_id" class="form-control">
                                            <option :value="building.id" v-for="building in buildings">{{ building.name }}</option>
                                        </select>
                                    </th>
                                    <th v-else>
                                        <select name="building_id" :value="classroom.building_id" class="form-control" disabled>
                                            <option :value="building.id" v-for="building in buildings">{{ building.name }}</option>
                                        </select>
                                    </th>
                                    <th>
                                        <button class="btn btn-primary" @click="update_classroom_info()" v-if="current_classroom.id==classroom.id">保存</button>
                                        <button class="btn btn-primary" @click="change_current_classroom(classroom)" v-else>修改</button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_classroom(classroom)">删除</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="classroomModel" tabindex="-1" role="dialog"
                                 aria-labelledby="classroomModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="classroomModelTitle">添加教室信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label text-md-right">教室名称</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   v-model:value="current_classroom.name"
                                                                   autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label text-md-right">教室门牌号</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   v-model:value="current_classroom.number"
                                                                   autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label text-md-right">所在教学楼</label>

                                                        <div class="col">
                                                            <select class="form-control" name="building_id" v-model:value="current_classroom.building_id">
                                                                <option value="0">--选择教学楼--</option>
                                                                <option :value="building.id" v-for="building in buildings">{{ building.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="add_classroom_info">保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-tab-department" role="tabpanel" aria-labelledby="list-tab-department-list">
                    <div class="card">
                        <h5 class="card-header">管理学院信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#departmentModel" @click="current_department={}">添加</button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">编号</th>
                                    <th scope="col">名称</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="department in departments">
                                    <th>{{ department.id }}</th>
                                    <th v-if="current_department.id==department.id">
                                        <input type="text" class="form-control text-center" v-model:value="current_department.name">
                                    </th>
                                    <th v-else>{{ department.name }}</th>
                                    <th>
                                        <button class="btn btn-primary" @click="update_department_info()" v-if="current_department.id==department.id">保存</button>
                                        <button class="btn btn-primary" @click="change_current_department(department)" v-else>修改</button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_department(department)">删除</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="departmentModel" tabindex="-1" role="dialog"
                                 aria-labelledby="departmentModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="departmentModelTitle">添加学院信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label for="number"
                                                               class="col-md-3 col-form-label text-md-right">学院名称</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="number"
                                                                   v-model:value="current_department.name"
                                                                   autofocus>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="add_department_info">保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-tab-major" role="tabpanel" aria-labelledby="list-tab-major-list">
                    <div class="card">
                        <h5 class="card-header">管理专业信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-secondary form-control"
                                            data-toggle="modal" data-target="#majorModel" @click="current_major={department_id:0}">添加</button>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">编号</th>
                                    <th scope="col">名称</th>
                                    <th scope="col">所在学院</th>
                                    <th scope="col">修改</th>
                                    <th scope="col">删除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="major in majors">
                                    <th>{{ major.id }}</th>
                                    <th v-if="current_major.id==major.id">
                                        <input type="text" class="form-control text-center" v-model:value="current_major.name">
                                    </th>
                                    <th v-else>{{ major.name }}</th>
                                    <th v-if="current_major.id==major.id">
                                        <select name="department_id" v-model:value="current_major.department_id" class="form-control">
                                            <option :value="department.id" v-for="department in departments">{{ department.name }}</option>
                                        </select>
                                    </th>
                                    <th v-else>
                                        <select name="department_id" :value="major.department_id" class="form-control" disabled>
                                            <option :value="department.id" v-for="department in departments">{{ department.name }}</option>
                                        </select>
                                    </th>
                                    <th>
                                        <button class="btn btn-primary" @click="update_major_info()" v-if="current_major.id==major.id">保存</button>
                                        <button class="btn btn-primary" @click="change_current_major(major)" v-else>修改</button>
                                    </th>
                                    <th>
                                        <button class="btn btn-danger" @click="delete_major(major)">删除</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="majorModel" tabindex="-1" role="dialog"
                                 aria-labelledby="majorModelTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="majorModelTitle">添加专业信息</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label text-md-right">专业名称</label>

                                                        <div class="col">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   v-model:value="current_major.name"
                                                                   autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label text-md-right">所在学院</label>

                                                        <div class="col">
                                                            <select class="form-control" name="building_id" v-model:value="current_major.department_id">
                                                                <option value="0">--选择学院--</option>
                                                                <option :value="department.id" v-for="department in departments">{{ department.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="add_major_info">保存信息
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                    <div class="card">
                        <h5 class="card-header">个人信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="username"
                                               class="col-md-3 col-form-label text-md-right">用户名</label>

                                        <div class="col">
                                            <input type="text"
                                                   class="form-control"
                                                   name="number"
                                                   v-model:value="user.username"
                                                   autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label text-md-right">邮箱</label>

                                        <div class="col">
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   v-model:value="user.email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password"
                                               class="col-md-3 col-form-label text-md-right">密码</label>

                                        <div class="col">
                                            <input type="text" placeholder="不更改"
                                                   v-model:value="user.password"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary form-control"
                                            @click="update_user_info()">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import bcrypt from 'bcryptjs';
    export default {
        name: "AdminComponent",
        data() {
            return {
                user: {},
                students: [],
                current_student: {},
                current_teacher: {},
                current_course: {},
                current_selectable_course: {},
                current_selectable_course_id: 0,
                current_building: {},
                current_classroom: {},
                current_department: {},
                current_major: {},
                teachers: [],
                buildings: [],
                majors: [],
                courses: [],
                selectable_courses: [],
                course_types: [],
                departments: [],
                classrooms: [],
                classess: [],
                current_arrangement_id: 0,
                current_arrangement_week_start: 0,
                current_arrangement_week_end: 0,
                current_arrangement_day: 0,
                current_arrangement_session_start: 0,
                current_arrangement_session_end: 0,
                current_arrangement_classroom_id: 0,
                new_arrangement_week_start: 0,
                new_arrangement_week_end: 0,
                new_arrangement_day: 0,
                new_arrangement_session_start: 0,
                new_arrangement_session_end: 0,
                new_arrangement_classroom_id: 0,
                sub_tab: 'list-tab-building',
                modify_mode: true,
                finish_date: new Date()
            }
        },
        mounted() {
            this.update_user()
            this.update_students()
            this.update_teachers()
            this.update_majors()
            this.update_courses()
            this.update_selectable_courses()
            this.update_departments()
            this.update_buildings()
            this.update_classrooms()
            this.update_course_types()
            this.get_finish()
            this.update_classes()
            $('#list-tab>.list-group-item').on('click', ()=> {
                $('#collapseOne').collapse('hide')
            })
        },
        methods: {
            update_user() {
                this.axios.get('/api/user/admin', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.user = res.data
                })
            },
            update_course_types() {
                this.axios.get(`/api/course_types`).then(res => {
                    this.course_types = res.data
                })
            },
            update_user_info() {
                if (this.user.password) {
                    this.user.password = bcrypt.hashSync(this.user.password)
                }
                this.axios.patch(`/api/admins/${this.user.id}`, {
                    api_token: $('#api_token').val(),
                    username: this.user.username,
                    email: this.user.email,
                    password: this.user.password
                }).then(res => {
                    this.update_user()
                }).finally(res => {
                    this.user.password=''
                })
            },
            change_model_state(state) {
                if (this.modify_mode) {
                    this.current_student = {
                        gender: 0,
                        major_id: 0
                    }
                    this.current_teacher = {
                        gender: 0
                    }
                    this.course = {
                        department_id: 0
                    }
                    this.current_selectable_course = {
                        teacher_id: 0,
                        course_id: 0
                    }
                }
                this.modify_mode = state
            },
            update_departments() {
                this.axios.get('/api/departments', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.departments = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_majors() {
                this.axios.get('/api/majors', {
                    params: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.majors = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_classes() {
                this.axios.get('/api/classes', {
                    params: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.classess = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_buildings() {
                this.axios.get('/api/buildings', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.buildings = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_classrooms() {
                this.axios.get('/api/classrooms', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.classrooms = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_students() {
                this.axios.get('/api/students', {
                    params: {
                        api_token: $('#api_token').val(),
                        department_id: $('#department_student').val(),
                        name: $('#student_name').val(),
                        number: $('#student_number').val()
                    }
                }).then(res => {
                    this.students = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_teachers() {
                this.axios.get('/api/teachers', {
                    params: {
                        api_token: $('#api_token').val(),
                        gender: $('#gender_teacher').val(),
                        name: $('#teacher_name').val(),
                        number: $('#teacher_number').val()
                    }
                }).then(res => {
                    this.teachers = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_courses() {
                this.axios.get('/api/courses', {
                    params: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.courses = res.data
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_selectable_courses() {
                this.axios.get('/api/selectable_course', {
                    params: {
                        teacher_id: $('#teacher').val(),
                        department_id: $('#department').val(),
                        course_name: $('#course_name').val(),
                        course_number: $('#course_number').val()
                    }
                }).then((res) => {
                    this.selectable_courses = res.data
                    if (this.current_selectable_course_id!==0) {
                        this.current_selectable_course = this.selectable_courses
                            .filter(it => it.id == this.current_selectable_course_id)[0]
                        if (!this.current_selectable_course) {
                            this.current_selectable_course_id = 0;
                            this.current_selectable_course = {}
                        }
                    }
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            change_current_student(index) {
                this.change_model_state(true)
                this.current_student = JSON.parse(JSON.stringify(this.students[index]))
            },
            update_student_info() {
                if (this.current_student.password) {
                    this.current_student.password = bcrypt.hashSync(this.current_student.password)
                }
                if (this.modify_mode) {
                    this.axios.patch(`/api/students/${this.current_student.id}`, {
                        api_token: $('#api_token').val(),
                        student: this.current_student
                    }).then(res => {
                        this.update_students()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                }
                else{
                    this.axios.post('/api/students', {
                        api_token: $('#api_token').val(),
                        student: this.current_student
                    }).then(res => {
                        this.update_students()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    }).finally(res => {
                        this.current_student.password = ''
                    })
                }
            },
            change_current_teacher(index) {
                this.change_model_state(true)
                this.current_teacher = JSON.parse(JSON.stringify(this.teachers[index]))
            },
            update_teacher_info() {
                if (this.current_teacher.password) {
                    this.current_teacher.password = bcrypt.hashSync(this.current_teacher.password)
                }
                if (this.modify_mode) {
                    this.axios.patch(`/api/teachers/${this.current_teacher.id}`, {
                        api_token: $('#api_token').val(),
                        teacher: this.current_teacher
                    }).then(res => {
                        this.update_teachers()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                } else {
                    this.axios.post('/api/teachers', {
                        api_token: $('#api_token').val(),
                        teacher: this.current_teacher
                    }).then(res => {
                        this.update_teachers()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    }).finally(res => {
                        this.current_teacher.password = ''
                    })
                }
            },
            change_current_course(index) {
                this.change_model_state(true)
                this.current_course = JSON.parse(JSON.stringify(this.courses[index]))
            },
            update_course_info() {
                if (this.modify_mode) {
                    this.axios.patch(`/api/courses/${this.current_course.id}`, {
                        api_token: $('#api_token').val(),
                        course: this.current_course
                    }).then(res => {
                        this.update_courses()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                } else {
                    this.axios.post('/api/courses', {
                        api_token: $('#api_token').val(),
                        course: this.current_course
                    }).then(res => {
                        this.update_courses()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                }
            },
            change_current_selectable_course(course) {
                this.change_model_state(true)
                this.current_selectable_course = JSON.parse(JSON.stringify(course))
                this.current_selectable_course_id = course.id
            },
            update_selectable_course_info() {
                if (this.modify_mode) {
                    this.axios.patch(`/api/selectable_course/${this.current_selectable_course.id}`, {
                        api_token: $('#api_token').val(),
                        selectable_course: this.current_selectable_course
                    }).then(res => {
                        this.update_selectable_courses()
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                        else{
                            $('.modal').modal('hide')
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                }
                else{
                    this.axios.post('/api/selectable_course', {
                        api_token: $('#api_token').val(),
                        selectable_course: this.current_selectable_course
                    }).then(res => {
                        this.update_selectable_courses()
                        $('.modal').modal('hide')
                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                }
            },
            change_current_building(building) {
                this.current_building=JSON.parse(JSON.stringify(building))
            },
            change_current_classroom(classroom) {
                this.current_classroom=JSON.parse(JSON.stringify(classroom))
            },
            change_current_department(department) {
                this.current_department=JSON.parse(JSON.stringify(department))
            },
            change_current_major(major) {
                this.current_major=JSON.parse(JSON.stringify(major))
            },
            update_building_info() {
                this.axios.patch(`/api/buildings/${this.current_building.id}`, {
                    api_token: $('#api_token').val(),
                    name: this.current_building.name
                }).then(res => {
                    this.update_buildings()
                    this.current_building = {}
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_classroom_info() {
                this.axios.patch(`/api/classrooms/${this.current_classroom.id}`, {
                    api_token: $('#api_token').val(),
                    name: this.current_classroom.name,
                    building_id: this.current_classroom.building_id
                }).then(res => {
                    this.update_classrooms()
                    this.current_classroom = {}
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_department_info() {
                this.axios.patch(`/api/departments/${this.current_department.id}`, {
                    api_token: $('#api_token').val(),
                    name: this.current_department.name
                }).then(res => {
                    this.update_departments()
                    this.current_department = {}
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            update_major_info() {
                this.axios.patch(`/api/majors/${this.current_major.id}`, {
                    api_token: $('#api_token').val(),
                    name: this.current_major.name,
                    department_id: this.current_major.department_id
                }).then(res => {
                    this.update_majors()
                    this.current_major = {}
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_building(building) {
                this.axios.delete(`/api/buildings/${building.id}`, {
                    data: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.update_buildings()
                    this.update_classrooms()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_classroom(classroom) {
                this.axios.delete(`/api/classrooms/${classroom.id}`, {
                    data: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.update_classrooms()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_department(department) {
                this.axios.delete(`/api/departments/${department.id}`, {
                    data: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.update_departments()
                    this.update_majors()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_major(major) {
                this.axios.delete(`/api/majors/${major.id}`, {
                    data: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.update_majors()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_student(student_id) {
                this.axios.delete(`/api/students/${student_id}`, {
                    data: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.update_students()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_teacher(teacher_id) {
                this.axios.delete(`/api/teachers/${teacher_id}`, {
                    data: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.update_teachers()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_course(course_id) {
                this.axios.delete(`/api/courses/${course_id}`, {
                    data: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.update_courses()
                    this.update_selectable_courses()
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            change_editing_index_or_update(arrangement) {
                if (this.current_arrangement_id !== arrangement.id) {
                    this.current_arrangement_id = arrangement.id

                    this.current_arrangement_classroom_id = arrangement.classroom_id
                    let [week_start, week_end] = arrangement.weeks.split('-');
                    this.current_arrangement_week_start = week_start
                    this.current_arrangement_week_end = week_end
                    let [day, sessions] = arrangement.sessions.split(':')
                    this.current_arrangement_day = day
                    let [session_start, session_end] = sessions.split('-')
                    this.current_arrangement_session_start = session_start
                    this.current_arrangement_session_end = session_end
                }
                else{
                    this.axios.patch(`/api/arrangements/${arrangement.id}`, {
                        api_token: $('#api_token').val(),
                        classroom_id: this.current_arrangement_classroom_id,
                        weeks: `${this.current_arrangement_week_start}-${this.current_arrangement_week_end}`,
                        sessions: `${this.current_arrangement_day}:${this.current_arrangement_session_start}-${this.current_arrangement_session_end}`
                    }).then(res => {
                        this.update_selectable_courses()
                        if (!res.data.success) {
                            alert(res.data.message)
                        }
                        else{
                            this.current_arrangement_id=0
                        }
                    }).catch(res => {
                        if (res.response && res.response.data && res.data.errors) {
                            let str = ''
                            for (let i of Object.values(res.response.data.errors)) {
                                for (let error of i) {
                                    str += `${i}\n`
                                }
                            }
                            alert(str)
                        }
                    })
                }
            },
            delete_arrangement(arrangement_id) {
                this.axios.delete(`/api/arrangements/${arrangement_id}`, {
                    data: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.update_selectable_courses()
                    this.current_arrangement_id=0
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            delete_selectable_course(selectable_course) {
                this.axios.delete(`/api/selectable_course/${selectable_course.id}`, {
                    data: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.update_selectable_courses()
                    this.current_selectable_course_id=0
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            add_arrangement() {
                this.axios.post(`/api/arrangements/`, {
                    api_token: $('#api_token').val(),
                    selectable_course_id: this.current_selectable_course.id,
                    classroom_id: this.new_arrangement_classroom_id,
                    weeks: `${this.new_arrangement_week_start}-${this.new_arrangement_week_end}`,
                    sessions: `${this.new_arrangement_day}:${this.new_arrangement_session_start}-${this.new_arrangement_session_end}`
                }).then(res => {
                    this.update_selectable_courses()
                    if (!res.data.success) {
                        alert(res.data.message)
                    }
                    else{
                        this.new_arrangement_week_start = 0
                        this.new_arrangement_week_end = 0
                        this.new_arrangement_day = 0
                        this.new_arrangement_session_start = 0
                        this.new_arrangement_session_end = 0
                        this.new_arrangement_classroom_id = 0
                    }
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            add_building_info() {
                this.axios.post(`/api/buildings`, {
                    api_token: $('#api_token').val(),
                    name: this.current_building.name
                }).then(res => {
                    this.update_buildings()
                    $('.modal').modal('hide')
                    if (res.data.message) {
                        alert(res.data.message)
                    }
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            add_classroom_info() {
                this.axios.post(`/api/classrooms`, {
                    api_token: $('#api_token').val(),
                    name: this.current_classroom.name,
                    number: this.current_classroom.number,
                    building_id: this.current_classroom.building_id
                }).then(res => {
                    this.update_classrooms()
                    $('.modal').modal('hide')
                    if (res.data.message) {
                        alert(res.data.message)
                    }
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            add_department_info() {
                this.axios.post(`/api/departments`, {
                    api_token: $('#api_token').val(),
                    name: this.current_department.name
                }).then(res => {
                    this.update_departments()
                    $('.modal').modal('hide')
                    if (res.data.message) {
                        alert(res.data.message)
                    }
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            add_major_info() {
                this.axios.post(`/api/majors`, {
                    api_token: $('#api_token').val(),
                    name: this.current_major.name,
                    department_id: this.current_major.department_id
                }).then(res => {
                    this.update_majors()
                    $('.modal').modal('hide')
                    if (res.data.message) {
                        alert(res.data.message)
                    }
                }).catch(res => {
                    if (res.response && res.response.data && res.data.errors) {
                        let str = ''
                        for (let i of Object.values(res.response.data.errors)) {
                            for (let error of i) {
                                str += `${i}\n`
                            }
                        }
                        alert(str)
                    }
                })
            },
            finish() {
                this.axios.post('/api/finish', {
                    api_token: $('#api_token').val(),
                    leave_data: $('#checkbox').prop('checked')
                }).then(res => {
                    console.log(res)
                    this.get_finish()
                })
            },
            get_finish() {
                this.axios.get('/api/finish', {
                    params: {
                        api_token: $('#api_token').val(),
                    }
                }).then(res => {
                    this.finish_date = new Date(res.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
