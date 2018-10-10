<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;

//use Intervention\Image\Image as Image;

class Uploader extends Model
{
    protected function doUpload($file,$path,$thumb=false,$pre=false){
        $response = [];
        $image = $file;
        $name = explode('.',$image->getClientOriginalName());
        $file = $name[0].time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path().$path;
        if($uploaded = $image->move($destinationPath, str_replace(' ','_',$file))){
//            if($thumb==true){
//                $thumbPath = public_path($path).'thumb/'.$file;
//                chmod($uploaded->getRealPath(), 0777);
//                if (!file_exists(public_path($path).'thumb/')) {
//                    mkdir(public_path($path).'thumb/', 0777, true);
//                }
//                $cropInfo = Image::make($uploaded->getRealPath())->resize(180, 180)->save($thumbPath);
//            }
            $response['status'] = true;
            $response['file']   = $path.$file;
        }else{
            $response['status'] = false;
        }
        return $response;

    }
    
    public function crop($path){
        Image::make($image->getRealPath())->resize(200, 200)->save($path);
        $user->image = $filename;
        $user->save();        
    }
    
    
    
}
