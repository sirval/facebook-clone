<?php

namespace App\Services;

use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileUpload
{
    public function postMediaUpload($files, $path) : array|bool
    {
        $i = 0;
        $succ = 0;
        $data = [];
        $extensions = ['jpg', 'jpeg', 'png'];
        if (is_array($files->file('fileInput'))) {
            foreach ($files->file('fileInput') as $file) {
                $fileName = Str::random(5) . time() . $i++;
                if (Str::lower($file->getClientOriginalExtension()) == 'mp4') {
                    $response = Cloudinary::uploadVideo($file->getRealPath(), ['public_id' => "{$path}/{$fileName}"])->getSecurePath();
                    $succ = 1;
                    array_push($data, ['filepath' => $response]);
                }else if (in_array(Str::lower($file->getClientOriginalExtension()), $extensions)) {
                    $response = Cloudinary::upload(
                        $file->getRealPath(),
                        ['public_id' => "{$path}/{$fileName}", 'quality'=>'auto', 'width'=>150, 'height'=>150,
                        'flags'=>['progressive', 'progressive:semi', 'progressive:steep'],  'fetch_format'=>'auto']
                    )->getSecurePath();
                    $succ = 1;
                    array_push($data, ['filepath' => $response]);
                } else {
                    $succ = 0;
                }
    
            }
        }else {
            $file = $files->file('fileInput'); 
                $fileName = Str::random(5) . time() . $i++;
                if (Str::lower($file->getClientOriginalExtension()) == 'mp4') {
                    $response = Cloudinary::uploadVideo($file->getRealPath(), ['public_id' => "{$path}/{$fileName}"])->getSecurePath();
                    $succ = 1;
                    array_push($data, ['filepath' => $response]);
                }else if (in_array(Str::lower($file->getClientOriginalExtension()), $extensions)) {
                    $response = Cloudinary::upload(
                        $file->getRealPath(),
                        ['public_id' => "{$path}/{$fileName}", 'quality'=>'auto', 'width'=>150, 'height'=>150,
                        'flags'=>['progressive', 'progressive:semi', 'progressive:steep'],  'fetch_format'=>'auto']
                    )->getSecurePath();
                    $succ = 1;
                    array_push($data, ['filepath' => $response]);
                } else {
                    $succ = 0;
                }
    
        }
        
        if ($succ === 1) {
            return $data;
        }

        return false;
    }

    public function deleteFile(array $filepaths, $option='uploads') : void
    {
        foreach ($filepaths as $filepath) {
            $filenameWithExtension = Str::afterLast($filepath, '/');
            $filename = Str::beforeLast($filenameWithExtension, '.');
            Cloudinary::destroy($option.'/'.$filename);
        }
    }
}