<?php
namespace App\Lib;
use Illuminate\Database\Eloquent\Model;
use Image;
use Illuminate\Support\Facades\Storage;
/**
 * 
 * 
 * This Library use for image upload and resizing.
 *  
 * 
 **/

class Uploader
{
    
    public static function doUpload($file,$path,$thumb=false,$pre=false){
        $response = [];
        $image = $file;
        $file = $pre.time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path().$path;
        //dd($destinationPath);
        if($uploaded = $image->move($destinationPath, $file)){
            if($thumb==true){
                $thumbPath = public_path($path).'thumb/'.$file;
                chmod($uploaded->getRealPath(), 0777);
                if (!file_exists(public_path($path).'thumb/')) {
                    mkdir(public_path($path).'thumb/', 0777, true);
                }
                $cropInfo = Image::make($uploaded->getRealPath())->resize(100, 100)->save($thumbPath);
            }
            $response['status']     = true;
            $response['file']       = "public".$path.$file;
            $response['file_name']  = $file;
            $response['path']       = $path;
        }else{
            $response['status']     = false;
        }
        return $response;

    }
    
    public static function base64($base64,$path){
        //echo $path; die;
        //dd($base64);
        $basePath = "public".$path;
        $path = public_path($path);
        $filePath = $path;
        //echo $path; die;
        @\File::makeDirectory($path, 0775, true);
        $image_parts = explode(";base64,", $base64);
        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid().'.'.$image_type;
        $filePath = $basePath.$fileName;
        $file = $path.$fileName;
        if(file_put_contents($file,$image_base64)){
            $response['status']     = true;
            $response['file']       = $filePath;
            $response['file_name']  = $filePath;
        }else{
            $response['status']     = false;
            $response['file']       = "";
        }
        return $response;
    }
    
}
