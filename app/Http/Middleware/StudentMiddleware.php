<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;
use App\Lesson;

class StudentMiddleware
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
        //获取路由参数
        $courseId = $request->courseId;
        $lessonId = $request->lessonId;

        //获取用户, 学生身份 $user->type=0, 老师身份 $user->type=1
        $user = auth('student')->user();
        if (!empty($user)) {
            $user->type = 0;
        } else {
            $user = auth('teacher')->user();
            if (!empty($user)) {
                $user->type = 1;
            }
        }
        $request->user = $user;
        view()->share('user', $user);

        //获取所有课程
        $courses = Course::query()->get();
        view()->share('courses', $courses);

        //课程存在则获取课程
        if (!empty($courseId)) {
            //此处不可用 findOrFail 故用 ?:
            $course = $courses->find($courseId)?:abort(404);
            $request->course = $course;
            view()->share('courseId', $courseId);
        }

        //用户登录且课时存在则获取课时
        if (!empty($lessonId)) {
            if (empty($user)) {
                return redirect()->action("StudentViewController@course", $courseId)->with('status', "您暂未登录, 请登录后查看");
            }
            $lesson = Lesson::query()->where('course_id', '>', 0)->findOrFail($lessonId);
            $request->lesson = $lesson;
            view()->share('lessonId', $lessonId);
        }

        return $next($request);
    }
}
