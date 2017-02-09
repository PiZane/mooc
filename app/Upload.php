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
     * @param bool $compress
     * @param null $width
     * @param null $height
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    static function imageUpload($image, $userId=-1, $path='public', $compress=false, $width=null, $height=null)
    {
        if (!empty($image) && $image->isValid() &&
            strpos($image->getClientMimeType(), 'image') !== false) {
            $extension = $image->getClientOriginalExtension()?:'png';
            $fileName = time().'_'.$userId.'.'.$extension;
            $url = url(Storage::url($image->storeAs($path, $fileName)));
            if ($compress) {
                self::compressImage(storage_path().'/app/'.$path.'/'.$fileName, $width, $height);
            }
            return $url;
        }
        return null;
    }

    /**
     * 压缩图片操作
     *
     * @param $fileName
     * @param null $newWidth
     * @param null $newHeight
     */
    static function compressImage($fileName, $newWidth=null, $newHeight=null)
    {
        if (!$newWidth || !$newHeight) {
            list($newWidth, $newHeight) = getimagesize($fileName);
        }
        list($width, $height) = getimagesize($fileName);
        $image = @imagecreatefrompng ($fileName);
        $newImage = imagecreatetruecolor($newWidth, $newWidth);
        imagecopyresized($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagepng ($newImage, $fileName, 2);
        imagedestroy ($image);
        imagedestroy ($newImage);
    }
}
