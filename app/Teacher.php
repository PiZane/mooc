<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'description'
    ];

    /**
     * 获取教师开设课程
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    /**
     * 获取教师开设课程的课时
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    /**
     * 获取教师发出的私信
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessages()
    {
        return $this->hasMany('App\Message', 'from_teacher_id');
    }

    /**
     * 获取教师接收的私信
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedMessages()
    {
        return $this->hasMany('App\Message', 'to_teacher_id');
    }
}
