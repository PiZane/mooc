<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class StudentActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    /**
     * 执行评论操作
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request)
    {
        //验证评论信息
        $this->validate($request, [
            'lessonId' => 'required|numeric',
            'commentContent'  => 'required|max:1024'
        ]);

        //验证登录
        if (empty($request->user)) {
            return redirect()->back()->with('status', "您暂未登录, 请登录后操作");
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
        return redirect()->back()->with('status', "评论发表成功");
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
            return '用户类型不正确';
        }
        if (empty($course->students()->find($user->id))){
            $course->students()->attach($user->id);
            return '成功加入课程';
        }
        return '已经加入该课程';
    }
}
