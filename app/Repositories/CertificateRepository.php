<?php

namespace App\Repositories;

use App\Models\Certificates;
use DB;
use Str;

class CertificateRepository
{
    
    public function getAll() {
        return Certificates::get();
    }

    public function getDropdown($is_premium=0) {
        return Certificates::pluck('name','id');
    }

    public function getPaginate($paginate = 10) {
        return Certificates::paginate(10);
    }

    public function FetchById($id) {
        return Certificates::findOrFail($id);
    }

    public function create($request) {
        $data   = [
            "ref"      => Str::random(50),
            "title"      => $request->get('title'),
            "name"      => $request->get('name'),
            "batch"      => $request->get('batch'),
            "details"      => json_encode($request->get('details')),
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
            "title"      => $request->get('title'),
            "name"      => $request->get('name'),
            "batch"      => $request->get('batch'),
            "details"      => json_encode($request->get('details')),
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