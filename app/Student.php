<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'school_id','name','class', 'email', 'password'
    ];

    /**
     * 获取学生的课程
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    /**
     * 获取学生发出的私信
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessages()
    {
        return $this->hasMany('App\Message', 'from_student_id');
    }

    /**
     * 获取学生接收的私信
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedMessages()
    {
        return $this->hasMany('App\Message', 'to_student_id');
    }
}
