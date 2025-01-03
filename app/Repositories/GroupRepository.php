<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\UserGroup;
use DB;

class GroupRepository
{
    
    public function getAll() {
        return Group::get();
    }

    public function getCount() {
        return Group::count();
    }

    public function getDropdown($is_premium=0) {
        return Group::pluck('name','id');
    }

    public function getPaginate($paginate = 10) {
        return Group::with(['data_group_user'])->paginate(10);
    }

    public function FetchById($id) {
        return Group::findOrFail($id);
    }

    public function getByGroup($fk_group) {
        return UserGroup::where('fk_group',$fk_group)->get();
    }

    public function create($request) {
        $data   = [
            "name"      => $request->get('name'),
            "description"      => $request->get('description'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $Group   = Group::create($data);

        foreach( $request->get('fk_user') as $key => $val ) {
            UserGroup::create([
                "fk_group" => $Group->id,
                "fk_user" => $val,
            ]);
        }
       
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

        UserGroup::where('fk_group',$Group->id)->delete();

        foreach( $request->get('fk_user') as $key => $val ) {
            UserGroup::create([
                "fk_group" => $Group->id,
                "fk_user" => $val,
            ]);
        }

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