<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Teacher;
use App\Course;

class TeacherViewController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $middleware = ['auth.phoenix:teacher', 'teacher'];
        $this->middleware($middleware);
    }

    /**
     * 后台首页视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('teacher.index');
    }

    /**
     * 教师课程视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function course(Request $request)
    {
        $courses = $request->teacher->courses()->get();
        return view('teacher.course', compact('courses'));
    }

    /**
     * 课程信息视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function courseInfo(Request $request)
    {
        $course = $request->course;
        $lessons = $course->lessons()->orderBy('created_at', 'desc')->paginate(9);
        return view('teacher.courseInfo', compact('course', 'lessons'));
    }

    /**
     * 创建章节视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createLesson(Request $request)
    {
        $course = $request->course;
        return view('teacher.createLesson', compact('course'));
    }

    /**
     * 章节信息视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lessonInfo(Request $request)
    {
        $course = $request->course;
        $lesson = $request->lesson;
        return view('teacher.lessonInfo', compact('course', 'lesson'));
    }

    /**
     * 显示私信视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message()
    {
        return view('teacher.message');
    }

    /**
     * 获取接收的私信以 Json 格式返回
     *
     * @param Request $request
     * @return string
     */
    public function getReceivedMessages(Request $request)
    {
        $receivedMessages = $request->teacher->receivedMessages()->with('studentSender')->latest()->paginate(5);
        $receivedMessages = Message::getCompleteMessages($receivedMessages);
        return json_encode($receivedMessages);
    }

    /**
     * 获取发送的私信以 Json 格式返回
     *
     * @param Request $request
     * @return string
     */
    public function getSentMessages(Request $request)
    {
        $sentMessages = $request->teacher->sentMessages()->with('studentReceiver')->latest()->paginate(5);
        return json_encode(Message::getCompleteMessages($sentMessages));
    }

    /**
     * 站点设置视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setting()
    {
        return view('teacher.setting');
    }
}
