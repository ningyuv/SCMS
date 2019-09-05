<?php

use App\CourseStudent;
use App\CourseType;
use App\SelectableCourse;
use App\Teacher;

function random_item($class, $strict=false, $classes_id=0){
    $size = models_size($class);
    $instance = $class::find(random_int(1, $size));
    if ($strict) {
        $instance = $class::all()->random();
        if ($class == SelectableCourse::class) {
            $instance = $class::where('classes_id', $classes_id)->get()->random();
        }
        if ($class == CourseType::class) {
            if (CourseType::first()->selectable_courses->where('classes_id', $classes_id)->count()>2) {
                $instance = CourseType::find(random_int(2,3));
            }
        }
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
function courses_array() {
    return [
        ['name' => '创新作品表现技法', 'department_id' => 1, 'credit' => 1.5],
        ['name' => '产品设计赏析', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '产品虚拟展示技术', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '产品语义设计', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '快题设计Ⅱ', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '设计公司实习A', 'department_id' => 1, 'credit' => 4.0],
        ['name' => '信息产品设计', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '毕业设计', 'department_id' => 1, 'credit' => 14.0],
        ['name' => '毕业实习', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '服务设计', 'department_id' => 1, 'credit' => 2.0],
        ['name' => 'CI设计', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '工程设计软件与应用', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '机械设计基础A', 'department_id' => 1, 'credit' => 4.0],
        ['name' => '快题设计Ⅰ', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '模型制作', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '设计初步', 'department_id' => 1, 'credit' => 4.0],
        ['name' => '设计速写III', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '包装设计', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '设计速写I', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '工业设计概论', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '平面设计软件应用A', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '设计启蒙', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '设计素描II', 'department_id' => 1, 'credit' => 4.0],
        ['name' => '设计制图A', 'department_id' => 1, 'credit' => 4.0],
        ['name' => '造型基础A', 'department_id' => 1, 'credit' => 4.0],
        ['name' => '可编程控制器原理', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '数控技术', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '机械原理课程设计', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '机械设计课程设计', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '认识实习', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '生产实习', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '机械产品拆装与测绘实践', 'department_id' => 1, 'credit' => 0.5],
        ['name' => '企业认识实习', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '测控技术与仪器专业导论', 'department_id' => 1, 'credit' => 1.0],
        ['name' => '测试技术A', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '测试技术B', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '工程光学', 'department_id' => 1, 'credit' => 2.5],
        ['name' => '嵌入式系统设计与应用', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '信号与系统D', 'department_id' => 1, 'credit' => 3.0],
        ['name' => 'DSP原理及应用', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '测控元件与电子线路', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '传感器原理', 'department_id' => 1, 'credit' => 3.0],
        ['name' => '电子技术课程设计', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '光电检测技术及应用', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '计算机控制技术基础', 'department_id' => 1, 'credit' => 2.0],
        ['name' => '毕业设计（论文）', 'department_id' => 2, 'credit' => 14.0],
        ['name' => '毕业实习', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '材料加工与性能实验', 'department_id' => 2, 'credit' => 1.0],
        ['name' => '大学生创新（创业）训练', 'department_id' => 2, 'credit' => 2.0],
        ['name' => '分析化学', 'department_id' => 2, 'credit' => 3.5],
        ['name' => '工程化学A', 'department_id' => 2, 'credit' => 1.5],
        ['name' => '工程化学B', 'department_id' => 2, 'credit' => 2.0],
        ['name' => '焊接工艺学', 'department_id' => 2, 'credit' => 4.0],
        ['name' => '基础电化学', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '计算材料学A', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '计算材料学B', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '胶体与界面化学', 'department_id' => 2, 'credit' => 2.0],
        ['name' => '金属工艺与材料工程', 'department_id' => 2, 'credit' => 4.0],
        ['name' => '热处理工艺学', 'department_id' => 2, 'credit' => 2.0],
        ['name' => '热处理设备', 'department_id' => 2, 'credit' => 1.5],
        ['name' => '生产实习', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '土木工程材料A', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '土木工程材料检测技术', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '无机材料物理化学', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '无机非金属材料工艺B', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '无机非金属材料生产设备B', 'department_id' => 2, 'credit' => 2.0],
        ['name' => '有机化学B', 'department_id' => 2, 'credit' => 2.0],
        ['name' => '专业技能训练', 'department_id' => 2, 'credit' => 3.0],
        ['name' => '专业英语', 'department_id' => 2, 'credit' => 2.0],
        ['name' => 'Android系统开发技术', 'department_id' => 3, 'credit' => 3.5],
        ['name' => 'Android系统课程设计', 'department_id' => 3, 'credit' => 2.0],
        ['name' => 'EDA技术', 'department_id' => 3, 'credit' => 2.0],
        ['name' => 'EDA技术课程设计', 'department_id' => 3, 'credit' => 1.5],
        ['name' => 'JAVA程序设计', 'department_id' => 3, 'credit' => 3.0],
        ['name' => '毕业设计', 'department_id' => 3, 'credit' => 11.0],
        ['name' => '毕业设计', 'department_id' => 3, 'credit' => 16.0],
        ['name' => '毕业实习', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '单片机接口设计', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '单片机原理及应用A', 'department_id' => 3, 'credit' => 4.0],
        ['name' => '单片机原理及应用B', 'department_id' => 3, 'credit' => 3.0],
        ['name' => '电工与电子技术B', 'department_id' => 3, 'credit' => 4.0],
        ['name' => '电力牵引自动控制系统', 'department_id' => 3, 'credit' => 4.0],
        ['name' => '电力拖动基础', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '电力系统分析A', 'department_id' => 3, 'credit' => 5.0],
        ['name' => '电路I', 'department_id' => 3, 'credit' => 4.0],
        ['name' => '电气测试技术', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '电气测试技术课程设计', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '电气工程CAD', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '电气工程CAD技能训练', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '电气控制与PLC应用技术', 'department_id' => 3, 'credit' => 2.5],
        ['name' => '电气控制与PLC应用技术课程设计', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '电子技术', 'department_id' => 3, 'credit' => 3.0],
        ['name' => '发电厂电气设备', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '工控软件及计算机监控系统设计', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '供电技术', 'department_id' => 3, 'credit' => 3.0],
        ['name' => '供电技术课程设计', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '过程控制与仪表', 'department_id' => 3, 'credit' => 3.5],
        ['name' => '过程控制与仪表课程设计', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '计算机辅助制图技能训练B', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '认识实习', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '生产实习', 'department_id' => 3, 'credit' => 4.0],
        ['name' => '数字电子技术A', 'department_id' => 3, 'credit' => 4.0],
        ['name' => '数字信号处理课程设计', 'department_id' => 3, 'credit' => 1.0],
        ['name' => '信息论与编码', 'department_id' => 3, 'credit' => 3.0],
        ['name' => '专业基础技能训练', 'department_id' => 3, 'credit' => 2.0],
        ['name' => '专业技能训练_电气工程设施日常管理与维护', 'department_id' => 3, 'credit' => 1.5],
        ['name' => '自动控制原理B', 'department_id' => 3, 'credit' => 4.0],
        ['name' => 'C++程序设计', 'department_id' => 4, 'credit' => 2.0],
        ['name' => 'E-learning与移动开发', 'department_id' => 4, 'credit' => 2.0],
        ['name' => 'Python程序设计', 'department_id' => 4, 'credit' => 2.0],
        ['name' => 'Web界面设计A', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '毕业设计', 'department_id' => 4, 'credit' => 13.0],
        ['name' => '毕业设计', 'department_id' => 4, 'credit' => 12.0],
        ['name' => '毕业实习', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '毕业实习', 'department_id' => 4, 'credit' => 5.0],
        ['name' => '操作系统A', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '程序设计技能训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '传感与信息采集', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '大型系统设计开发综合训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '多媒体技术及应用', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '计算机网络', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '计算机组成原理B', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '交互动画综合训练', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '教育游戏设计与开发', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '面向对象程序设计', 'department_id' => 4, 'credit' => 2.5],
        ['name' => '嵌入式技术及应用', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '人机交互综合训练', 'department_id' => 4, 'credit' => 1.0],
        ['name' => '认识实习', 'department_id' => 4, 'credit' => 1.0],
        ['name' => '数据库系统开发综合训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '算法与数据结构综合训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '网络安全技术', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '网络安全技术综合训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '网络管理综合训练', 'department_id' => 4, 'credit' => 1.5],
        ['name' => '网络规划与设计', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '网络教育资源设计与开发', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '网络系统集成综合训练', 'department_id' => 4, 'credit' => 1.5],
        ['name' => '心理学概论', 'department_id' => 4, 'credit' => 3.0],
        ['name' => '信号与系统', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '信息系统设计与开发', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '虚拟现实工程仿真训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '虚拟现实技术A', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '游戏建模实训', 'department_id' => 4, 'credit' => 1.0],
        ['name' => '游戏开发综合训练', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '游戏设计与制作', 'department_id' => 4, 'credit' => 4.0],
        ['name' => '游戏原理', 'department_id' => 4, 'credit' => 2.0],
        ['name' => '游戏中的人工智能', 'department_id' => 4, 'credit' => 2.0],
        ['name' => 'FIDIC合同框架', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '安全工程讲座', 'department_id' => 5, 'credit' => 0.5],
        ['name' => '安全经济学', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '城市地下空间讲座', 'department_id' => 5, 'credit' => 0.5],
        ['name' => '地质灾害防治', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '房屋建筑工程（A）', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '工程测量实习B', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '工程结构可靠度基础 B', 'department_id' => 5, 'credit' => 1.5],
        ['name' => '工程抗震原理与技术', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '工程识图与制图', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '工程图学基础', 'department_id' => 5, 'credit' => 3.5],
        ['name' => '国际工程标书翻译', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '国际工程英语阅读', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '国际建筑市场概论及趋势分析', 'department_id' => 5, 'credit' => 1.0],
        ['name' => '画法几何与工程制图', 'department_id' => 5, 'credit' => 4.0],
        ['name' => '混凝土结构设计原理 C', 'department_id' => 5, 'credit' => 3.5],
        ['name' => '计算机绘图（A）', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '建筑施工', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '课程设计', 'department_id' => 5, 'credit' => 1.0],
        ['name' => '桥梁工程（A）', 'department_id' => 5, 'credit' => 3.5],
        ['name' => '桥梁工程（B）', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '桥梁工程（C）', 'department_id' => 5, 'credit' => 3.0],
        ['name' => '铁道工程（A）', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '铁路路基工程(B)', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '铁路选线设计(B)', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '土木工程概论 A', 'department_id' => 5, 'credit' => 1.0],
        ['name' => '土木工程前沿科技讲座', 'department_id' => 5, 'credit' => 1.0],
        ['name' => '土木工程施工组织', 'department_id' => 5, 'credit' => 1.5],
        ['name' => '现代预应力混凝土概论', 'department_id' => 5, 'credit' => 1.5],
        ['name' => '岩体力学', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '制图基础', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '中国铁建国际工程案例分析', 'department_id' => 5, 'credit' => 1.0],
        ['name' => '专业基础技能训练(工程测量)', 'department_id' => 5, 'credit' => 3.5],
        ['name' => '专业认识实习', 'department_id' => 5, 'credit' => 2.0],
        ['name' => '专业英语（土木）', 'department_id' => 5, 'credit' => 2.0],
    ];
}
function course_types_array() {
    return [
        '必修',
        '限选',
        '任选',
    ];
}
function department_names_array() {
    return [
        '机械工程学院',
        '材料科学与工程学院',
        '电气工程学院',
        '信息科学与技术学院',
        '土木工程学院',
    ];
}
function majors_array() {
    return [
        ['name' => '工程训练中心', 'department_id' => 1],
        ['name' => '机械基础实验中心', 'department_id' => 1],
        ['name' => '工程图学部', 'department_id' => 1],
        ['name' => '机械工学部', 'department_id' => 1],
        ['name' => '机械制造及其自动化系', 'department_id' => 1],
        ['name' => '塑性成形工程系', 'department_id' => 1],
        ['name' => '机电控制工程系', 'department_id' => 1],
        ['name' => '机械电子工程系', 'department_id' => 1],
        ['name' => '机械设计系', 'department_id' => 1],
        ['name' => '冶金机械系', 'department_id' => 1],
        ['name' => '高分子材料系', 'department_id' => 2],
        ['name' => '材料物理系', 'department_id' => 2],
        ['name' => '无机非金属材料系', 'department_id' => 2],
        ['name' => '金属材料系', 'department_id' => 2],
        ['name' => '电子实验中心', 'department_id' => 3],
        ['name' => '生物医学工程系', 'department_id' => 3],
        ['name' => '电气工程及自动化系', 'department_id' => 3],
        ['name' => '电力工程系', 'department_id' => 3],
        ['name' => '自动化仪表系', 'department_id' => 3],
        ['name' => '仪器科学与工程系', 'department_id' => 3],
        ['name' => '自动化系', 'department_id' => 3],
        ['name' => '软件工程系', 'department_id' => 4],
        ['name' => '教育技术学系', 'department_id' => 4],
        ['name' => '通信工程系', 'department_id' => 4],
        ['name' => '计算机科学与技术系', 'department_id' => 4],
        ['name' => '数字媒体系', 'department_id' => 4],
        ['name' => '网络工程系', 'department_id' => 4],
        ['name' => '建筑系', 'department_id' => 5],
        ['name' => '建筑环境与能源应用工程系', 'department_id' => 5],
        ['name' => '工程力学系', 'department_id' => 5],
        ['name' => '土木工程系', 'department_id' => 5],
    ];
}
function teachers_array() {
    return [
        ['name' => '曹京亚', 'gender' => 2, 'department_id' => 1],
        ['name' => '常冰', 'gender' => 1, 'department_id' => 1],
        ['name' => '陈长虹', 'gender' => 1, 'department_id' => 1],
        ['name' => '陈恩利', 'gender' => 1, 'department_id' => 1],
        ['name' => '陈国华', 'gender' => 1, 'department_id' => 1],
        ['name' => '代树合', 'gender' => 1, 'department_id' => 1],
        ['name' => '邓飞跃', 'gender' => 1, 'department_id' => 1],
        ['name' => '曹雅彬', 'gender' => 1, 'department_id' => 2],
        ['name' => '陈艳雪', 'gender' => 2, 'department_id' => 2],
        ['name' => '刁建志', 'gender' => 1, 'department_id' => 2],
        ['name' => '丁占来', 'gender' => 1, 'department_id' => 2],
        ['name' => '杜永刚', 'gender' => 1, 'department_id' => 2],
        ['name' => '冯梦楠', 'gender' => 2, 'department_id' => 2],
        ['name' => '付华', 'gender' => 2, 'department_id' => 2],
        ['name' => '白雪飞', 'gender' => 2, 'department_id' => 3],
        ['name' => '鲍怀义', 'gender' => 1, 'department_id' => 3],
        ['name' => '卞建鹏', 'gender' => 1, 'department_id' => 3],
        ['name' => '蔡承才', 'gender' => 1, 'department_id' => 3],
        ['name' => '常宇健', 'gender' => 2, 'department_id' => 3],
        ['name' => '陈立松', 'gender' => 1, 'department_id' => 3],
        ['name' => '陈勇', 'gender' => 1, 'department_id' => 3],
        ['name' => '陈东阳', 'gender' => 1, 'department_id' => 4],
        ['name' => '陈娜', 'gender' => 2, 'department_id' => 4],
        ['name' => '段淑凤', 'gender' => 2, 'department_id' => 4],
        ['name' => '方庆园', 'gender' => 2, 'department_id' => 4],
        ['name' => '封筠', 'gender' => 2, 'department_id' => 4],
        ['name' => '冯魏巍', 'gender' => 1, 'department_id' => 4],
        ['name' => '高志伟', 'gender' => 1, 'department_id' => 4],
        ['name' => '艾庆华', 'gender' => 1, 'department_id' => 5],
        ['name' => '安蕊梅', 'gender' => 2, 'department_id' => 5],
        ['name' => '白宝鸿', 'gender' => 1, 'department_id' => 5],
        ['name' => '白建方', 'gender' => 1, 'department_id' => 5],
        ['name' => '曹立辉', 'gender' => 1, 'department_id' => 5],
        ['name' => '常建梅', 'gender' => 2, 'department_id' => 5],
    ];
}
function buildings_array() {
    return [
        ['name' => '基教'],
        ['name' => '一教'],
        ['name' => '二教'],
        ['name' => '三教'],
        ['name' => '四教'],
    ];
}
function classrooms_array() {
    return [
        ['name' => '102教室','number' => '102', 'building_id' => 1],
        ['name' => '103教室','number' => '103', 'building_id' => 1],
        ['name' => '101教室','number' => '101', 'building_id' => 1],
        ['name' => '204教室','number' => '204', 'building_id' => 1],
        ['name' => '205教室','number' => '205', 'building_id' => 1],
        ['name' => '206教室','number' => '206', 'building_id' => 1],
        ['name' => '301教室','number' => '301', 'building_id' => 2],
        ['name' => '302教室','number' => '302', 'building_id' => 2],
        ['name' => '303教室','number' => '303', 'building_id' => 2],
        ['name' => '304教室','number' => '304', 'building_id' => 2],
        ['name' => '305教室','number' => '305', 'building_id' => 2],
        ['name' => '306教室','number' => '306', 'building_id' => 2],
        ['name' => '108教室','number' => '108', 'building_id' => 3],
        ['name' => '108教室','number' => '108', 'building_id' => 3],
        ['name' => '108教室','number' => '108', 'building_id' => 3],
        ['name' => '208教室','number' => '208', 'building_id' => 3],
        ['name' => '208教室','number' => '208', 'building_id' => 3],
        ['name' => '208教室','number' => '208', 'building_id' => 3],
        ['name' => '401教室','number' => '401', 'building_id' => 4],
        ['name' => '402教室','number' => '402', 'building_id' => 4],
        ['name' => '403教室','number' => '403', 'building_id' => 4],
        ['name' => '404教室','number' => '404', 'building_id' => 4],
        ['name' => '405教室','number' => '405', 'building_id' => 4],
        ['name' => '406教室','number' => '406', 'building_id' => 4],
        ['name' => '109教室','number' => '109', 'building_id' => 5],
        ['name' => '109教室','number' => '109', 'building_id' => 5],
        ['name' => '109教室','number' => '109', 'building_id' => 5],
        ['name' => '209教室','number' => '209', 'building_id' => 5],
        ['name' => '209教室','number' => '209', 'building_id' => 5],
        ['name' => '209教室','number' => '209', 'building_id' => 5],
    ];
}
function classes_array() {
    return [
        ['name' => '1701班', 'number' => '1701', 'year' => 2017],
        ['name' => '1702班', 'number' => '1702', 'year' => 2017],
        ['name' => '1703班', 'number' => '1703', 'year' => 2017],
        ['name' => '1704班', 'number' => '1704', 'year' => 2017],
        ['name' => '1801班', 'number' => '1801', 'year' => 2018],
        ['name' => '1802班', 'number' => '1802', 'year' => 2018],
        ['name' => '1803班', 'number' => '1803', 'year' => 2018],
        ['name' => '1804班', 'number' => '1804', 'year' => 2018],
        ['name' => '1901班', 'number' => '1901', 'year' => 2019],
        ['name' => '1902班', 'number' => '1902', 'year' => 2019],
        ['name' => '1903班', 'number' => '1903', 'year' => 2019],
        ['name' => '1904班', 'number' => '1904', 'year' => 2019],
    ];
}
