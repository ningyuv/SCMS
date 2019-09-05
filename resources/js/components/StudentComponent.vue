<template>

    <div class="row">
        <div class="col-2">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active"
                   id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">选课</a>
                <a class="list-group-item list-group-item-action"
                   id="list-profile-list" data-toggle="list" href="#list-profile" role="tab"
                   aria-controls="profile">已选课程</a>
                <a class="list-group-item list-group-item-action"
                   id="list-messages-list" data-toggle="list" href="#list-messages" role="tab"
                   aria-controls="messages">个人信息</a>
            </div>
        </div>
        <div class="col-10">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active"
                     id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                    <div class="card">
                        <h5 class="card-header">选课</h5>
                        <div class="card-body">
                            <div class="row">
                                <h3 class="col-md-2">必修学分: {{ compulsory_credit }}/{{ user.compulsory_credit }}</h3>
                                <h3 class="col-md-2">限选学分: {{ restriction_credit }}/{{ user.restriction_credit }}</h3>
                                <h3 class="col-md-2">任选学分: {{ optional_credit }}/{{ user.optional_credit }}</h3>
                            </div>
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
                                    <select name="course_type" id="course_type_id" class="form-control">
                                        <option value="0">--课程性质--</option>
                                        <option :value="course_type.id" v-for="course_type in course_types">{{
                                            course_type.name }}
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
                                    <button type="submit" class="btn btn-primary form-control"
                                            @click="update_selectable_courses">查询
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
                                    <th scope="col">开课院系</th>
                                    <th scope="col">学分</th>
                                    <th scope="col">上课时间地点</th>
                                    <th scope="col">教师</th>
                                    <th scope="col">选课</th>
                                    <th scope="col">选课人数</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="course in selectable_courses">
                                    <th>{{ course.id }}</th>
                                    <th>{{ course.course.number }}</th>
                                    <th>{{ course.course_type.name }}</th>
                                    <th>{{ course.course.name }}</th>
                                    <th>{{ course.course.department?course.course.department.name:'' }}</th>
                                    <th>{{ course.course.credit }}</th>
                                    <th>
                                        <div v-for="arrangement in course.arrangements">
                                            {{ arrangement.weeks }}周 星期{{ arrangement.sessions }}节 {{ arrangement.classroom?arrangement.classroom.name:'无教室' }}
                                        </div>
                                    </th>
                                    <th>{{ course.teacher?course.teacher.name:'' }}</th>
                                    <th>
                                        <button :class="['btn', [is_selected(course.id)?'btn-danger':'btn-success']]"
                                                @click="toggle_selected(course.id)" :disabled="toggling||course.course_type_id==1">
                                            {{is_selected(course.id)?'删除':'选课'}}
                                        </button>
                                    </th>
                                    <th>{{ course.students.length }}/{{ course.max_num }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                    <div class="card">
                        <h5 class="card-header">按周查课表</h5>
                        <div class="card-body">
                            <button class="btn btn-primary" data-toggle="modal"
                                    data-target=".bd-example-modal-xl">按周查课表
                            </button>
                            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                                 aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl mw-100 pl-md-4 pr-md-4">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">
                                                按周查课表
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <table id="courses" class="table table-bordered mt-4 text-center">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">周一</th>
                                                <th scope="col">周二</th>
                                                <th scope="col">周三</th>
                                                <th scope="col">周四</th>
                                                <th scope="col">周五</th>
                                                <th scope="col">周六</th>
                                                <th scope="col">周日</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="i in Array(12).fill(0).map((_,x)=>x)">
                                                <th>{{i+1}}</th>
                                                <th v-for="j in Array(7).fill(0).map((_,x)=>x)">
                                                    <div
                                                        v-if="courses[i] && courses[i][j]">
                                                        <div v-for="arrangement in courses[i][j]">
                                                            <div>
                                                                {{ arrangement.selectable_course.course.number }} {{
                                                                arrangement.selectable_course.course.name }} ({{ arrangement.selectable_course.teacher?arrangement.selectable_course.teacher.name:'' }})
                                                            </div>
                                                            <div>
                                                                {{ arrangement.weeks }} 周
                                                            </div>
                                                            <div>
                                                                {{ arrangement.classroom?arrangement.classroom.building.name:'' }} {{
                                                                arrangement.classroom?arrangement.classroom.name:'无教室' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 text-center">
                                <thead>
                                <tr>
                                    <th scope="col">编号</th>
                                    <th scope="col">课程编号</th>
                                    <th scope="col">课程性质</th>
                                    <th scope="col">课程名称</th>
                                    <th scope="col">开课院系</th>
                                    <th scope="col">学分</th>
                                    <th scope="col">上课时间地点</th>
                                    <th scope="col">教师</th>
                                    <th scope="col">选课</th>
                                    <th scope="col">选课人数</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="course in user.selectable_courses">
                                    <th>{{ course.id }}</th>
                                    <th>{{ course.course.number }}</th>
                                    <th>{{ course.course_type.name }}</th>
                                    <th>{{ course.course.name }}</th>
                                    <th>{{ course.course.department.name }}</th>
                                    <th>{{ course.course.credit }}</th>
                                    <th>
                                        <div v-for="arrangement in course.arrangements">
                                            {{ arrangement.weeks }}周 星期{{ arrangement.sessions }}节 {{ arrangement.classroom?arrangement.classroom.name:'无教室' }}
                                        </div>
                                    </th>
                                    <th>{{ course.teacher?course.teacher.name:'' }}</th>
                                    <th>
                                        <button :class="['btn', [is_selected(course.id)?'btn-danger':'btn-success']]"
                                                @click="toggle_selected(course.id)" :disabled="toggling||course.course_type_id==1">
                                            {{is_selected(course.id)?'删除':'选课'}}
                                        </button>
                                    </th>
                                    <th>{{ course.students.length }}/{{ course.max_num }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                    <div class="card">
                        <h5 class="card-header">个人信息</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="number" class="col-md-4 col-form-label text-md-right">学号</label>

                                        <div class="col-md-6">
                                            <input id="number" type="text"
                                                   class="form-control"
                                                   name="number" :value="user.number" disabled
                                                   autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">姓名</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                   class="form-control"
                                                   name="name" :value="user.name" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gender" class="col-md-4 col-form-label text-md-right">性别</label>

                                        <div class="col-md-6">
                                            <select id="gender"
                                                    class="form-control"
                                                    name="gender" :value="user.gender" disabled>
                                                <option value="1">男</option>
                                                <option value="2">女</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="enrollment_year"
                                               class="col-md-4 col-form-label text-md-right">入学年份</label>

                                        <div class="col-md-6">
                                            <input id="enrollment_year" type="text"
                                                   class="form-control"
                                                   :value="user.enrollment_year" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="department_id"
                                               class="col-md-4 col-form-label text-md-right">院系</label>

                                        <div class="col-md-6">
                                            <select id="department_id"
                                                    class="form-control"
                                                    :value="user.major.department_id" disabled>
                                                <option :value="department.id" v-for="department in departments">{{
                                                    department.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="major" class="col-md-4 col-form-label text-md-right">专业</label>

                                        <div class="col-md-6">
                                            <input id="major" type="text"
                                                   class="form-control"
                                                   :value="user.major.name" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>

                                        <div class="col-md-6">
                                            <input id="password" type="text" v-model:value="current_student_password"
                                                   class="form-control" placeholder="不更改" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary form-control"
                                            @click="change_password()">修改密码</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">...
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import bcrypt from 'bcryptjs'
    export default {
        name: "CourseStudentComponent",
        data() {
            return {
                selectable_courses: [],
                user: {
                    selectable_courses: [],
                    major: {}
                },
                course_student: [],
                current_student_password: '',
                teachers: [],
                departments: [],
                course_types: [],
                toggling: false,
                genders: ['未知', '男', '女'],
                courses: []
            }
        },
        methods: {
            update_selectable_courses() {
                this.axios.get('/api/selectable_course', {
                    params: {
                        teacher_id: $('#teacher').val(),
                        department_id: $('#department').val(),
                        course_name: $('#course_name').val(),
                        course_number: $('#course_number').val(),
                        course_type_id: $('#course_type_id').val()
                    }
                }).then((res) => {
                    this.selectable_courses = res.data
                    this.update_user()
                })
            },
            update_course_student() {
                this.axios.get('/api/course_student').then((res) => {
                    this.course_student = res.data
                })
            },
            update_course_types() {
                this.axios.get(`/api/course_types`).then(res => {
                    this.course_types = res.data
                })
            },
            update_user() {
                this.axios.get('/api/user/student', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.user = res.data
                    let courses = Array(12).fill(0).map(() => Array(7).fill(0).map(() => {
                        return []
                    }))
                    res.data.selectable_courses.forEach((course, index) => {
                        course.arrangements.forEach(arrangement => {
                            arrangement.sessions.split('&').forEach(it => {
                                let day_sessions = it.split(':')
                                let day = parseInt(day_sessions[0])
                                let [start, end] = day_sessions[1].split('-')
                                for (let i = start; i <= end; ++i) {
                                    courses[i - 1][day - 1].push(arrangement)
                                }
                            })
                        })
                    })
                    this.courses = courses
                    this.toggling = false
                })
            },
            update_teachers() {
                this.axios.get('/api/teachers', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.teachers = res.data
                })
            },
            update_departments() {
                this.axios.get('/api/departments', {
                    params: {
                        api_token: $('#api_token').val()
                    }
                }).then(res => {
                    this.departments = res.data
                })
            },
            is_selected(course_id) {
                return this.user.selectable_courses.some(it => it.id == course_id)
            },
            toggle_selected(course_id) {
                this.toggling = true
                if (this.is_selected(course_id)) {
                    this.axios.delete(`/api/course_student/${this.course_student.filter(
                        it => it.student_id == this.user.id && it.selectable_course_id == course_id
                    )[0].id}`, {
                        data: {
                            api_token: $('#api_token').val()
                        }
                    }).then(res => {
                        this.update_user()
                        this.update_course_student()
                        this.update_selectable_courses()
                    })
                } else {
                    this.axios.post('api/course_student', {
                        api_token: $('#api_token').val(),
                        student_id: this.user.id,
                        selectable_course_id: course_id
                    }).then(res => {
                        this.update_user()
                        this.update_course_student()
                        this.update_selectable_courses()

                        if (res.data.message) {
                            alert(res.data.message)
                        }
                    })
                }
            },
            change_password() {
                if (this.current_student_password) {
                    this.current_student_password = bcrypt.hashSync(this.current_student_password)
                }
                this.axios.patch(`/api/students/${this.user.id}`, {
                    api_token: $('#api_token').val(),
                    student: {
                        password: this.current_student_password
                    }
                }).then(res => {
                    this.update_students()
                    $('.modal').modal('hide')
                }).catch(err => {
                    if(err.response.data.message) {
                        alert(err.response.data.message)
                    }
                }).finally(res => {
                    this.current_student_password = ''
                })
            }
        },
        mounted() {
            this.update_selectable_courses()
            this.update_user()
            this.update_course_student()
            this.update_teachers()
            this.update_departments()
            this.update_course_types()
        },
        computed: {
            compulsory_credit() {
                let credit = 0
                console.log(this.user.selectable_courses)
                for (let i of this.user.selectable_courses.filter(it=>it.course_type_id==1)) {
                    credit+=parseFloat(i.course.credit)
                }
                return credit.toFixed(1)
            },
            restriction_credit() {
                let credit = 0
                for (let i of this.user.selectable_courses.filter(it=>it.course_type_id==2)) {
                    credit+=parseFloat(i.course.credit)
                }
                return credit.toFixed(1)
            },
            optional_credit() {
                let credit = 0
                for (let i of this.user.selectable_courses.filter(it=>it.course_type_id==3)) {
                    credit+=parseFloat(i.course.credit)
                }
                return credit.toFixed(1)
            }
        }
    }
</script>

<style scoped>

</style>
