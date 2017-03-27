<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'description', 'broad', 'image_url', 'teacher_id', 'student_id'
    ];

    /**
     * 获取课程的章节
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    /**
     * 获取课程的教师
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    /**
     * 获取课程的学生
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany('App\Student');
    }
}
