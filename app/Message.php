<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * 获取发信学生
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentSender()
    {
        return $this->belongsTo('App\Student', 'from_student_id');
    }

    /**
     * 获取接收学生
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentReceiver()
    {
        return $this->belongsTo('App\Student', 'to_student_id');
    }

    /**
     * 获取发信教师
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacherSender()
    {
        return $this->belongsTo('App\Teacher', 'from_teacher_id');
    }

    /**
     * 获取接收教师
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacherReceiver()
    {
        return $this->belongsTo('App\Teacher', 'to_teacher_id');
    }
}
