<?php

namespace App\Repositories;

use App\Models\Chapters;
use DB;

class ChaptersRepository
{
    
    public function getAll() {
        return Chapters::orderBy('position','ASC')->get();
    }

    public function getDropdown($is_premium=0) {
        return Chapters::orderBy('position','ASC')->pluck('name','id');
    }

    public function getPaginate($paginate = 10, $search = []) {
        $query =  Chapters::with(['data_module']);
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        return $query->orderBy('position','ASC')->paginate($paginate);
    }

    public function getPaginateByModule($fk_module, $paginate = 10, $search) {
        $query =  Chapters::with(['data_module']);
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        return $query->where('fk_module',$fk_module)->orderBy('position','ASC')->paginate($paginate);
    }

    public function FetchById($id) {
        return Chapters::findOrFail($id);
    }

    public function create($request) {
        $data   = [
            "fk_module"      => $request->get('fk_module'),
            "name"      => $request->get('name'),
            "description"      => $request->get('description'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $Chapters   = Chapters::create($data);
       
        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function update($id, $request)
    {
        $data   = [
            "fk_module"      => $request->get('fk_module'),
            "name"      => $request->get('name'),
            "description"      => $request->get('description'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $Chapters   = Chapters::find($id);
        $Chapters->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        Chapters::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}