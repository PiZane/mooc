<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Comment extends Model
{
    protected $fillable = [
        'content', 'top', 'reply_id', 'teacher_id', 'student_id', 'lesson_id'
    ];

    /**
     * 获取评论所属课程
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    /**
     * 获取评论所属教师
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'teacher_id');
    }

    /**
     * 获取评论所属学生
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }

    /**
     * 获取回复的评论 (即嵌套评论)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reply()
    {
        return $this->belongsTo('App\Comment', 'reply_id', 'id');
    }

    /**
     * 获取多个完整的评论信息
     *
     * @param  $comments
     * @return mixed
     */
    static function getCompleteComments($comments)
    {
        foreach ($comments as $key => $comment) {
            $comment = Comment::completeComment($comment);
            //用户信息置为 null 防止信息泄漏
            $comment->relations['student'] = null;
            $comment->relations['teacher'] = null;
            $comments[$key] = $comment;
        }
        return $comments;
    }

    /**
     * 获取完整评论信息 (即包括用户信息的评论及嵌套评论)
     *
     * @param  $comment
     * @param  int $i   嵌套评论层级
     * @return mixed
     */
    static function completeComment($comment, $i=1)
    {
        if (!$i) {
            $comment->reply = null;
        }
        if ($comment->reply) {
            $reply = $comment->reply;
            if (!empty($reply) && $i) {
                $i--;
                $comment->reply = Comment::completeComment($reply, $i);
            }
        }
        if ($comment->teacher) {
            $user = $comment->teacher;
            $comment->type  = 1;
        } else {
            $user = $comment->student;
            $comment->type  = 0;
            $comment->schoolId  = $user->school_id;
        }
        $comment->name = $user->name;
        $comment->image_url = $user->image_url;
        $comment->time = $comment->created_at->diffForHumans();
        return $comment;
    }
}
