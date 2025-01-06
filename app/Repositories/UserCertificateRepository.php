<?php

namespace App\Repositories;

use App\Models\Certificates;
use DB;

class UserCertificateRepository
{
    
    public function getAll() {
        return Certificates::orderBy('position','ASC')->get();
    }

    public function getDropdown($is_premium=0) {
        return Certificates::orderBy('position','ASC')->pluck('name','id');
    }

    public function getPaginate($paginate = 10) {
        return Certificates::with(['data_module'])->orderBy('position','ASC')->paginate(10);
    }

    public function getPaginateByModule($fk_module, $paginate = 10) {
        return Certificates::where('fk_module',$fk_module)->orderBy('position','ASC')->paginate(10);
    }

    public function FetchById($id) {
        return Certificates::findOrFail($id);
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

        $Certificates   = Certificates::create($data);
       
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

        $Certificates   = Certificates::find($id);
        $Certificates->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        Certificates::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}