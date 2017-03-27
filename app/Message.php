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

    /**
     * 完善私信
     *
     * @param $messages
     * @return mixed
     */
    static function getCompleteMessages($messages)
    {
        foreach ($messages as $key => $message) {
            if (!empty($message->studentSender)) {
                $message->senderName = $message->studentSender->name;
                $message->school_id  = $message->studentSender->school_id;
            } else if (!empty($message->teacherSender)) {
                $message->senderName = $message->teacherSender->name;
            }
            if (!empty($message->studentReceiver)) {
                $message->receiverName = $message->studentReceiver->name;
                $message->school_id    = $message->studentReceiver->school_id;
            } else if (!empty($message->teacherReceiver)) {
                $message->receiverName = $message->teacherReceiver->name;
            }
            $message->time = $message->created_at->diffForHumans();
            $message->relations['studentSender']   = null;
            $message->relations['teacherSender']   = null;
            $message->relations['studentReceiver'] = null;
            $message->relations['teacherReceiver'] = null;
            $messages[$key] = $message;
        }
        return $messages;
    }
}
