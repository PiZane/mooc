<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;
use App\Course;
use App\Lesson;

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
        ]);
        //图片上传
        $image_url = Upload::imageUpload($request->file('image'), $request->teacher->id, 'public/course');
        //创建课程
        $course = new Course();
        $course->image_url   = $image_url;
        $course->name        = $request->name;
        $course->description = $request->description;
        $course->broad       = $request->broad;
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
        $course->broad       = $request->broad;
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
        //验证表单
        $this->validate($request, [
            'title' => 'required|max:255',
            'type'  => 'required'
        ]);
        $lesson = new Lesson();
        $lesson->type         = $request->type;
        $lesson->title        = $request->title;
        $lesson->board        = $request->board;
        $lesson->image_url    = $request->image_url;
        $lesson->video_url    = $request->video_url;
        $lesson->text_content = $request->text_content;
        $lesson->course_id    = $request->course->id;
        $lesson->teacher_id   = $request->teacher->id;
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
        ]);
        $lesson = $request->lesson;
        $lesson->type         = $request->type;
        $lesson->title        = $request->title;
        $lesson->board        = $request->board;
        $lesson->image_url    = $request->image_url;
        $lesson->video_url    = $request->video_url;
        $lesson->text_content = $request->text_content;
        $lesson->save();
        return redirect()->back()->with('status', '成功修改本课时');
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
