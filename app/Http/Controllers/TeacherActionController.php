<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Course;
use App\Lesson;
use App\Student;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherActionController extends Controller
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
     * 创建课程
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createCourse(Request $request)
    {
        //验证表单
        $this->validate($request, [
            'name' => 'required|unique:courses|max:255',
        ], [
            'name.required' => '课程名不可为空',
            'name.courses' => '课程名重复',
            'name.max' => '课程名长度超出限制',
        ]);
        //图片上传
        $image_url = Upload::imageUpload($request->file('image'), $request->teacher->id, 'public/course');
        //创建课程
        $course = new Course();
        $course->image_url   = $image_url;
        $course->name        = $request->name;
        $course->description = $request->description;
        $course->board       = $request->board;
        $course->teacher_id  = $request->teacher->id;
        $course->save();
        return redirect()->back()->with('status', '成功创建课程');
    }

    /**
     * 修改课程
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editCourse(Request $request)
    {
        $course = $request->course;
        //验证表单
        $this->validate($request, [
            'name' => 'required|max:255',
        ], [
            'name.required' => '课程名不可为空',
            'name.courses' => '课程名重复',
            'name.max' => '课程名长度超出限制',
        ]);
        //确认修改后的课程名不与其它课程重名
        $temp = Course::where('name', $request->name)->first();
        if (!empty($temp) && $temp->id != $course->id) {
            return redirect()->back()->with('status', '修改失败, 课程名称重复');
        }
        //图片上传
        $image_url = Upload::imageUpload($request->file('image'), $request->teacher->id, 'public/course');
        if ($image_url) {
            $course->image_url = $image_url;
        }
        $course->name        = $request->name;
        $course->description = $request->description;
        $course->board       = $request->board;
        $course->save();
        return redirect()->back()->with('status', '成功修改课程信息');
    }

    /**
     * 删除课程
     *
     * @param Request $request
     * @return string
     */
    public function deleteCourse(Request $request)
    {
        $request->course->delete();
        return '{"status":"ok"}';
    }

    /**
     * 创建课时
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createLesson(Request $request)
    {
        //验证表单 type=1 为图文类型 type=0 为视频类型
        $this->validate($request, [
            'title' => 'required|max:255',
            'type'  => 'required'
        ], [
            'title.required' => '课时标题不可为空',
            'title.max' => '课时标题超出长度限制'
        ]);
        //视频内容认证 视频链接和html视频代码不能全为空
        if (!$request->type &&
            empty($request->video_url) &&
            empty($request->video_content)) {
            return redirect()->back()->with('status', '视频链接和html视频代码至少填写一项');
        }
        $lesson = new Lesson();
        $lesson->type          = $request->type;
        $lesson->title         = $request->title;
        $lesson->board         = $request->board;
        $lesson->image_url     = $request->image_url;
        $lesson->video_url     = $request->video_url;
        $lesson->text_content  = $request->text_content;
        $lesson->video_content = $request->video_content;
        $lesson->course_id     = $request->course->id;
        $lesson->teacher_id    = $request->teacher->id;
        $lesson->save();
        return redirect()->back()->with('status', '成功添加课时');
    }

    /**
     * 修改课时
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editLesson(Request $request)
    {
        //验证表单
        $this->validate($request, [
            'title' => 'required|max:255',
            'type'  => 'required'
        ], [
            'title.required' => '课时标题不可为空',
            'title.max' => '课时标题超出长度限制'
        ]);
        //视频内容认证 视频链接和html视频代码不能全为空
        if (!$request->type &&
            empty($request->video_url) &&
            empty($request->video_content)) {
            return redirect()->back()->with('status', '视频链接和html视频代码至少填写一项');
        }
        $lesson = $request->lesson;
        $lesson->type          = $request->type;
        $lesson->title         = $request->title;
        $lesson->board         = $request->board;
        $lesson->image_url     = $request->image_url;
        $lesson->video_url     = $request->video_url;
        $lesson->text_content  = $request->text_content;
        $lesson->video_content = $request->video_content;
        $lesson->save();
        return redirect()->back()->with('status', '成功修改本课时');
    }

    public function deleteLesson(Request $request)
    {
        $request->lesson->delete();
        return '{"status":"ok"}';
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
            'school_id' => 'required|numeric',
            'messageContent'  => 'required|max:1024'
        ], [
            'school_id.required' => '学号不可为空',
            'messageContent.required' => '内容不可为空',
            'messageContent.max' => '内容长度超出限制'
        ]);
        $schoolId = $request->school_id;
        $student = Student::query()->where('school_id', $schoolId)->first();
        if (empty($student)) {
            return redirect()->back()->withErrors('发送私信失败, 请检查学号输入是否正确');
        }
        $message = new Message();
        $message->content         = $request->messageContent;
        $message->to_student_id   = $student->id;
        $message->from_teacher_id = $request->teacher->id;
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
        if ($message->to_teacher_id != $request->teacher->id) {
            return '该私信不属于您';
        }
        $message->delete = 1;
        $message->save();
        return '删除成功';
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
        ], [
            'name.required' => '姓名必须填写'
        ]);
        $teacher = $request->teacher;
        $teacher->name = $request->name;
        $teacher->description = $request->description;
        $teacher->save();
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
        $teacher = $request->teacher;
        $avatar = Upload::imageUpload($request->avatar, $teacher->id, 'public/teacher/avatar', true, 120, 120);
        $teacher->image_url = $avatar;
        $teacher->save();
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
            'newPassword.min' => '新密码不能少于6位字符'
        ]);
        $teacher = $request->teacher;
        if (Hash::check($request->oldPassword, $teacher->password)) {
            $password = bcrypt($request->newPassword);
            $teacher->password = $password;
            $teacher->save();
            return redirect()->action("TeacherAuth\\TLoginController@logout")->with('status', '密码修改成功');
        } else {
            return redirect()->back()->withErrors('原密码错误');
        }
    }

    /**
     * 修改站点信息
     *
     * @param Request $request
     * @return string
     */
    public function setting(Request $request)
    {
        if (empty($request->setting)){
            return 'empty setting value';
        }
        $temp = json_decode($request->setting);
        if ($temp) {
            file_put_contents(base_path('/config/setting.json'), $request->setting);
            return '200';
        } else {
            return 'wrong setting value';
        }
    }
}
