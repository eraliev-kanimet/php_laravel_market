<?php

namespace App\Http\AdminControllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Facades\Image;

class AdminController extends BaseController
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

    /**
     * @param Request $request
     * @param array $new_images
     * @param array $old_images
     * @param array $removed
     * @return array
     */
    public function saveImages(Request $request, array $new_images = [], array $old_images = [], array $removed = []): array
    {
        $data = [];
        foreach ($new_images as $key => $value) {
            if ($request->hasFile($value)) {
                $data[] = $this->saveImage($request->file($value));
            } else {
                foreach ($removed as $item) {
                    if ($item == $key) {
                        $data[] = '';
                    } else {
                        $data[] = $old_images[$key];
                    }
                }
            }
        }
        return $data;
    }
}