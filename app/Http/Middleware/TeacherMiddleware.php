<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;
use App\Lesson;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取教师实例
        $request->teacher = auth('teacher')->user();
        view()->share('teacher', $request->teacher);
        //如果路由参数存在课程 ID , 则获取课程实例并验证权限
        if (!empty($request->courseId)) {
            $request->course = Course::findOrFail($request->courseId);
            if ($request->course->teacher_id !== $request->teacher->id) {
                return redirect()->back()->with('status', '该课程不属于您');
            }
        }
        //如果路由参数存在章节 ID , 则获取章节实例并验证权限
        if (!empty($request->lessonId)) {
            $request->lesson = Lesson::findOrFail($request->lessonId);
            if ($request->lesson->teacher_id !== $request->teacher->id) {
                return redirect()->back()->with('status', '该课程不属于您');
            }
        }
        return $next($request);
    }
}
