<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
    'type', 'comment', 'title', 'board', 'image_url', 'video_url', 'text_content', 'video_content'
    ];

    /**
     * 获取课时的评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * 获取课时的课程
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    /**
     * 获取课时的封面
     *
     * @return bool|mixed
     */
    public function getImage()
    {
        $image_url = $this->image_url;
        if (!empty($image_url)) {
            return $image_url;
        }
        $image_url = $this->course()->first()->image_url;
        if (!empty($image_url)) {
            return $image_url;
        }
        return false;
    }
}
