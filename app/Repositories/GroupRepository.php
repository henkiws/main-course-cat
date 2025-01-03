<?php

namespace App\Repositories;

use App\Models\Group;
use DB;

class GroupRepository
{
    
    public function getAll() {
        return Group::get();
    }

    public function getDropdown($is_premium=0) {
        return Group::pluck('name','id');
    }

    public function getPaginate($paginate = 10) {
        return Group::paginate(10);
    }

    public function FetchById($id) {
        return Group::findOrFail($id);
    }

    public function create($request) {
        $data   = [
            "name"      => $request->get('name'),
            "description"      => $request->get('description'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $Group   = Group::create($data);
       
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
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $Group   = Group::find($id);
        $Group->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        Group::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}