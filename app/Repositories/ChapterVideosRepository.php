<?php

namespace App\Repositories;

use App\Models\ChapterVideos;
use App\Traits\FileUploadTrait;
use DB;

class ChapterVideosRepository
{   
    use FileUploadTrait;
    
    public function getAll() {
        return ChapterVideos::orderBy('position','ASC')->get();
    }

    public function getDropdown($is_premium=0) {
        return ChapterVideos::orderBy('position','ASC')->pluck('name','id');
    }

    public function getPaginate($paginate = 10, $search = []) {
        $query =  ChapterVideos::query();
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        return $query->orderBy('position','ASC')->paginate($paginate);
    }

    public function getPaginateByChapter($fk_chapter, $paginate = 10) {
        return ChapterVideos::where('fk_chapter',$fk_chapter)->orderBy('position','ASC')->paginate($paginate);
    }

    public function countByChapter($fk_chapter) {
        return ChapterVideos::where('fk_chapter',$fk_chapter)->count();
    }

    public function FetchById($id) {
        return ChapterVideos::findOrFail($id);
    }

    public function FetchByChapter($fk_chapter) {
        return ChapterVideos::where('fk_chapter',$fk_chapter)->get();
    }

    public function create($request) {
        $data   = [
            "title"      => $request->get('title'),
            "description"      => $request->get('description'),
            "fk_chapter"      => $request->get('fk_chapter'),
            "link"      => $request->get('link'),
            "date_class"      => $request->get('date_class'),
            "tutor"      => $request->get('tutor'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        if( $request->filepath ) {
            $file   = $request->filepath;
            $folder = 'files/video';
            $res    = $this->uploadFileOnly($file,$folder);

            $data['filepath']   = $res['path'];
        }

        $ChapterVideos   = ChapterVideos::create($data);
       
        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function update($id, $request)
    {
        $data   = [
            "title"      => $request->get('title'),
            "description"      => $request->get('description'),
            "fk_chapter"      => $request->get('fk_chapter'),
            "link"      => $request->get('link'),
            "date_class"      => $request->get('date_class'),
            "tutor"      => $request->get('tutor'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        if( $request->filepath ) {
            $file   = $request->filepath;
            $folder = 'files/video';
            $res    = $this->uploadFileOnly($file,$folder);

            $data['filepath']   = $res['path'];
        }

        $ChapterVideos   = ChapterVideos::find($id);
        $ChapterVideos->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        ChapterVideos::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}