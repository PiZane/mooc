<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    /**
     * 图片上传处理
     *
     * @param $image
     * @param int $userId
     * @param string $path
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    static function imageUpload($image, $userId=-1, $path='public')
    {
        if (!empty($image) && $image->isValid() &&
            strpos($image->getClientMimeType(), 'image') !== false) {
            $fileName = time().'_'.$userId.'.'.$image->getClientOriginalExtension();
            $url = url(Storage::url($image->storeAs($path, $fileName)));
            return $url;
        }
        return null;
    }

    static function avatarUpload($avatar, $userId=-1)
    {
        $avatar   = base64_decode($avatar);
        $fileName = time().'_'.$userId.'.png';
        file_put_contents(storage_path().'/app/public/'.$fileName, $avatar);
        return url('storage/'.$fileName);
    }
}
