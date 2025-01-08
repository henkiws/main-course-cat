<?php

namespace App\Repositories;

use App\Models\Modules;
use DB;

class ModulesRepository
{
    
    public function getAll() {
        return Modules::orderBy('position','ASC')->get();
    }

    public function getCount() {
        return Modules::count();
    }

    public function getDropdown($is_premium=0) {
        return Modules::orderBy('position','ASC')->pluck('name','id');
    }

    public function getPaginate($paginate = 10, $search = []) {
        $query =  Modules::with(['data_chapters']);
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        return $query->orderBy('position','ASC')->paginate($paginate);
    }

    public function FetchById($id) {
        return Modules::findOrFail($id);
    }

    public function create($request) {
        $data   = [
            "name"      => $request->get('name'),
            "description"      => $request->get('description'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $Modules   = Modules::create($data);
       
        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function update($id, $request)
    {
        $data   = [
            "name"      => $request->get('name'),
            "description"      => $request->get('description'),
            "position"      => $request->get('position'),
            "active"      => 1,
        ];

        $Modules   = Modules::find($id);
        $Modules->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        Modules::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}