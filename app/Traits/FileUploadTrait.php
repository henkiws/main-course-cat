<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;
use File;

trait FileUploadTrait {

    public function uploadFile($file, $folder_name = '', $params = [], $model) {
        $img        = $params;
        $filename   = $file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
        $file->move($path, $filename);

        $img['filename']    = $filename;
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        $res_img            = $model::create($img);
        
        return $res_img;
    }

    public function uploadFileByUrl($url, $folder_name = '', $params = [], $model) {
        $img        = $params;
        $imageContent = file_get_contents($url);
        $filename   = Str::random(40);
        $infoPath = pathinfo($url);
        $extension = $infoPath['extension'];
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename.'.'.$extension;

        Storage::disk('public_data')->put($path_file, $imageContent);

        $img['filename']    = $filename;
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        $res_img            = $model::create($img);
        
        return $res_img;
    }

    public function uploadFileMedia($file, $folder_name = '', $params = [], $model) {
        $img        = $params;
        $fname      = md5(Str::random(40));
        // $filename   = $file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();
        $filename 	= $fname. '.' . $extension;
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
        $file->move($path, $filename);

        $img['filename']    = $filename;
        $img['image_size']  = 'original';
        $img['path']        = $path_file;
        $img['name']        = $fname;
        $img['extention']   = $extension;
        $res_img            = $model::create($img);

        // image compress size
        $filename 	= $fname. '_medium.' . $extension;
        $image  = Image::make(file_get_contents(public_path($path_file)));
        $path = public_path('data/'.$folder_name);

        $image->fit(600, 365)->save($path.'/'.$filename);

        // $image->resize(600, 600, function ($constraint) {
        //     // $constraint->aspectRatio();
        //     // $constraint->upsize();
        // })->save($path.'/'.$filename);
        $path_file  = 'data/'.$folder_name.'/'.$filename;

        $img['filename']    = $filename;
        $img['image_size']  = 'medium';
        $img['path']        = $path_file;
        $img['name']        = $fname;
        $img['extention']   = $extension;
        $res_img            = $model::create($img);
        // end image compress size
        
        return $res_img;
    }

    public function uploadFileOnly($file, $folder_name = '', $unique_filename = '', $is_crop = false) {
        $extension  = $file->getClientOriginalExtension();
        if( empty($unique_filename) ) {
            $filename   = $file->getClientOriginalName();
        }else{
            $filename   = $unique_filename.'.'.$extension;
        }
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
        $file->move($path, $filename);

        if( $is_crop ) {
            $image  = Image::make(file_get_contents(public_path($path_file)));
            $path = public_path('data/'.$folder_name);
            $image->fit(300, 300)->save($path.'/'.$filename);
            $path_file  = 'data/'.$folder_name.'/'.$filename;
        }

        $img['filename']    = $filename;
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        
        return $img;
    }

    public function uploadFileBase64($file, $folder_name = '', $params = [], $model) {
        $imgdata 		= base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
		$info_image 	= getimagesizefromstring($imgdata);

        if( !$info_image ) {
			return [
				'status' 	=> 'error',
				'msg'		=> 'Error when get information image'
			];
		}
		$mime_type 		= $info_image['mime'];
		$list_accept 	= ['image/jpeg', 'image/png'];

		if(!in_array($mime_type, $list_accept)) {
			return [
				'status' 	=> 'error',
				'msg'		=> 'Wrong file type'
			];
		}

		$type_file 		= 'jpg';
		if($mime_type == 'image/png') {
			$type_file 	= 'png';
        }

        $img        = $params;
        $fname      = md5(Str::random(40));
        $filename 	= $fname. '.' . $type_file;
        $extension  = $type_file;
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
        if (!file_exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        Image::make(file_get_contents($file))->save($path.'/'.$filename);     

        $img['filename']    = $filename;
        $img['image_size']  = 'original';
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        $res_img            = $model::create($img);

        // image compress size
        $filename 	= $fname. '_medium.' . $type_file;
        $image  = Image::make(file_get_contents($file));
        $path = public_path('data/'.$folder_name);
        $image->resize(600, 600, function ($constraint) {
            // $constraint->aspectRatio();
            // $constraint->upsize();
        })->save($path.'/'.$filename);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
   
        // $image->move($path, $filename);

        $img['filename']    = $filename;
        $img['image_size']  = 'medium';
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        $res_img            = $model::create($img);
        // end image compress size
        
        return $res_img;
    }

    public function uploadFileBase64Only($file, $folder_name = '', $params = []) {
        $imgdata 		= base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
		$info_image 	= getimagesizefromstring($imgdata);

        if( !$info_image ) {
			return [
				'status' 	=> 'error',
				'msg'		=> 'Error when get information image'
			];
		}
		$mime_type 		= $info_image['mime'];
		$list_accept 	= ['image/jpeg', 'image/png'];

		if(!in_array($mime_type, $list_accept)) {
			return [
				'status' 	=> 'error',
				'msg'		=> 'Wrong file type'
			];
		}

		$type_file 		= 'jpg';
		if($mime_type == 'image/png') {
			$type_file 	= 'png';
        }

        $img        = $params;
        $fname      = md5(Str::random(40));
        $filename 	= $fname. '.' . $type_file;
        $extension  = $type_file;
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
        if (!file_exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        Image::make(file_get_contents($file))->save($path.'/'.$filename);     

        $img['filename']    = $filename;
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        
        return $img;
    }

    public function uploadFileAndUpdate($file, $folder_name = '', $params = [], $model, $id) {
        $img        = $params;
        $filename   = $file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();
        $path       = public_path('data/'.$folder_name);
        $path_file  = 'data/'.$folder_name.'/'.$filename;
        $file->move($path, $filename);

        $dt = $model::find($id);

        $img['filename']    = $filename;
        $img['path']        = $path_file;
        $img['extention']   = $extension;
        $dt->update($img);
        $res_img            = $dt;
        
        return $res_img;
    }

    public function deleteFileByName($filename, $model) {
        $model::where('filename',$filename)->delete();
        $file_path = public_path('data/menu').'/'.$filename;
        if(File::exists($file_path)){
            File::delete($file_path);
        }
        return 1;
    }

    public function createDirectory($path) {
        $fullpath = public_path().'/'.$path;
        File::makeDirectory($fullpath, 0777, true, true);
        return true;
    }

}