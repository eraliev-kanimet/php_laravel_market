<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $file
     * @return string
     */
    public function saveImage($file): string
    {
        $dir = 'storage/pictures/' . date('Y') . '/' . date('m') . '/' . date('d');
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
        $path = $dir . '/' . md5(time()) . $file->getClientOriginalName();
        Image::make($file)->resize(600, 500)->save($path);
        return $path;
    }
}