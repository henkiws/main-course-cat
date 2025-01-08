<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use DB;

class RoleRepository
{
    
    public function getAll() {
        return Role::get();
    }

    public function getDropdown($is_premium=0) {
        return Role::pluck('name','id');
    }

    public function getPaginate($paginate = 10, $search = []) {
        $query =  Role::query();
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        return $query->paginate($paginate);
    }

    public function FetchById($id) {
        return Role::findOrFail($id);
    }

    public function create($request) {
        $data   = [
            "name"      => $request->get('name')
        ];

        $Role   = Role::create($data);
       
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
        ];

        $Role   = Role::find($id);
        $Role->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        Role::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}