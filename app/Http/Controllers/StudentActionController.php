<?php

namespace App\Http\Controllers;

use App\Message;
use App\Teacher;
use App\Upload;
use App\Student;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    /**
     * 修改个人信息
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editProfile(Request $request)
    {
        //验证表单
        $this->validate($request, [
            'name' => 'required|max:255',
            'class' => 'required|max:255',
            'school_id' => 'required|alpha_num|max:255'
        ], [
            'name.required' => '姓名必须填写',
            'class.required' => '班级必须填写',
            'school_id.required' => '学号必须填写',
            'school_id.alpha_num' => '学号必须为字母或数字'
        ]);
        $user = $request->user;
        if (empty($user) || $user->type) {
            return redirect('/')->with('status', 'error');
        }
        $student = Student::query()->find($user->id);
        $student->name      = $request->name;
        $student->class     = $request->class;
        $student->school_id = $request->school_id;
        $student->save();
        return redirect()->back()->with('status', '个人信息已更新');
    }

    /**
     * 修改头像
     *
     * @param Request $request
     * @return string
     */
    public function editAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
        ], [
            'avatar.required' => '头像内容不能为空',
        ]);
        $user = $request->user;
        if (empty($user)) {
            return '未登录无法上传';
        }
        $avatar = Upload::imageUpload($request->avatar, $user->id, 'public/avatar', true, 120, 120);
        $student = Student::query()->find($user->id);
        $student->image_url = $avatar;
        $student->save();
        return '头像修改成功';
    }

    /**
     * 修改密码
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPassword(Request $request)
    {
        $this->validate($request, [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6|confirmed',
        ], [
            'oldPassword.required' => '当前密码必须填写',
            'newPassword.required' => '新密码必须填写',
            'newPassword.min' => '新密码不能少于6位字符',
        ]);
        $user = $request->user;
        $student = Student::query()->find($user->id);
        if (Hash::check($request->oldPassword, $student->password)) {
            $password = bcrypt($request->newPassword);
            $student->password = $password;
            $student->save();
            return redirect()->action("StudentAuth\\SLoginController@logout")->with('status', '密码修改成功');
        } else {
            return redirect()->back()->withErrors('原密码错误');
        }
    }

    /**
     * 执行评论操作
     *
     * @param Request $request
     * @return string
     */
    public function comment(Request $request)
    {
        //验证评论信息
        $this->validate($request, [
            'lessonId' => 'required|numeric',
            'commentContent'  => 'required|max:1024'
        ], [
            'commentContent.required' => '评论内容不能为空',
            'commentContent.max' => '评论内容长度超出限制'
        ]);

        //验证登录
        if (empty($request->user)) {
            return "您暂未登录, 请登录后操作";
        }

        //保存评论
        $user = $request->user;
        $comment = new Comment();
        $comment->top        = $user->type;
        $comment->content    = $request->commentContent;
        $comment->reply_id   = $request->replyId?:null;
        $comment->lesson_id  = $request->lessonId;
        $comment->student_id = $user->type?null:$user->id;
        $comment->teacher_id = $user->type?$user->id:null;
        $comment->save();
        return "评论发表成功";
    }

    /**
     * 加入课程操作
     *
     * @param Request $request
     * @return string
     */
    public function joinCourse(Request $request)
    {
        $user   = $request->user;
        $course = $request->course;
        if (empty($user)) {
            return '您未登录';
        }
        if ($user->type) {
            return '您的身份是教师,无需加入课程';
        }
        if (empty($course->students()->find($user->id))) {
            $course->students()->attach($user->id);
            return '成功加入课程';
        }
        return '已经加入该课程';
    }

    /**
     * 发送私信
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'teacherId' => 'required|numeric',
            'messageContent'  => 'required|max:1024'
        ], [
            'teacherId.required' => '必须选择教师',
            'messageContent.required' => '内容不可为空',
            'messageContent.max' => '内容长度超出限制'
        ]);
        $teacher = Teacher::query()->findOrFail($request->teacherId);
        $message = new Message();
        $message->content         = $request->messageContent;
        $message->to_teacher_id   = $teacher->id;
        $message->from_student_id = $request->user->id;
        $message->save();
        return redirect()->back()->with('status', '私信发送成功');
    }

    /**
     * 删除私信
     *
     * @param Request $request
     * @param $messageId
     * @return string
     */
    public function deleteMessage(Request $request, $messageId)
    {
        $message = Message::query()->findOrFail($messageId);
        if ($message->to_student_id != $request->user->id) {
            return '该私信不属于您';
        }
        $message->delete = 1;
        $message->save();
        return '删除成功';
    }
}
