<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;
use App\Comment;
use App\Teacher;
use App\Message;

class StudentViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    /**
     * 显示首页视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lessons = Lesson::query()->where('course_id', '>', 0)->latest()->paginate(9);
        return view('student.index', compact('lessons'));
    }

    /**
     * 显示个人主页视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        $user = $request->user;
        if ($user->type) {
            return redirect()->action("TeacherViewController@index");
        }
        $studentCourses = $user->courses;
        return view('student.profile', compact('studentCourses'));
    }

    /**
     * 显示私信视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function message(Request $request)
    {
        if ($request->user->type) {
            return redirect()->action("TeacherViewController@message");
        }
        $teachers = Teacher::query()->get();
        return view('student.message', compact('teachers'));
    }

    /**
     * 获取接收的私信以 Json 格式返回
     *
     * @param Request $request
     * @return string
     */
    public function getReceivedMessages(Request $request)
    {
        $receivedMessages = $request->user->receivedMessages()->where('delete', 0)->with('teacherSender')->latest()->paginate(5);
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
        $sentMessages = $request->user->sentMessages()->with('teacherReceiver')->latest()->paginate(5);
        return json_encode(Message::getCompleteMessages($sentMessages));
    }

    /**
     * 显示课程视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function course(Request $request)
    {
        $course  = $request->course;
        $teacher = $course->teacher;
        $lessons = Lesson::query()->where('course_id', $course->id)->latest()->paginate(9);

        //设置用户选课状态, 未登录或为加入课程 $joinStatus=0 加入课程后 $joinStatus=1
        if (empty($request->user)) {
            $joinStatus = 0;
        } else {
            $joinStatus = $course->students()->find($request->user->id)?1:0;
        }

        return view('student.course', compact('course', 'teacher', 'lessons', 'joinStatus'));
    }

    /**
     * 显示课时视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function lesson(Request $request)
    {
        //获取中间件传递变量
        $course = $request->course;
        $lesson = $request->lesson;
        $user   = $request->user;

        //获取课程所有课时
        $lessons = Lesson::query()->where('course_id', $course->id)->latest()->paginate(9);

        //确认用户已加入本课程
        if (!$user->type) {
            $temp = $user->courses()->find($course->id);
            if (empty($temp)) {
                return redirect()->action("StudentViewController@course", $course->id)->with('status', "您暂未加入该课程");
            }
        }

        //获取置顶评论
        $topComments = $lesson->comments()->where('top', 1)->orderBy('created_at', 'DESC')->take(3)->get();
        $topComments = Comment::getCompleteComments($topComments);

        return view('student.lesson', compact('course', 'lesson', 'lessons', 'topComments'));
    }

    /**
     * 获取课时评论以 Json 格式返回
     *
     * @param Request $request
     * @return string
     */
    public function comment(Request $request)
    {
        $lesson = $request->lesson;
        //获取该课程的评论, 按时间倒序, 评论必须有用户对应即 student_id or teacher_id > 0 同时获取评论所属用户及回复
        $comments = $lesson->comments()
                    ->where(function($query) {
                            $query->where('student_id','>',0)
                                ->orWhere('teacher_id','>',0);
                            })
                    ->latest()
                    ->with('teacher', 'student', 'reply')
                    ->paginate(3);
        //完善评论信息
        $comments = Comment::getCompleteComments($comments);

        return json_encode($comments);
    }
}
