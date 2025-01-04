<?php

namespace App\Repositories\CAT;

use App\Models\CAT\CATGroup;
use DB;

class CATGroupRepository
{

    public function getAll() {
        return CATGroup::get();
    }

    public function getCount() {
        return CATGroup::count();
    }

    public function getDropdown($is_premium=0) {
        return CATGroup::pluck('grup_nama','grup_id');
    }

    public function getPaginate($paginate = 10) {
        return CATGroup::paginate(10);
    }

    public function FetchById($id) {
        return CATGroup::where('grup_id',$id)->first();
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data   = [
                "grup_nama"      => $request->get('grup_nama'),
            ];

            $Group   = CATGroup::create($data);
            
            DB::commit();
            return [
                "status"    => "success",
                "msg"       => "Data has been saved successfully!",
                "data"      => $Group
            ];
        }catch (\Exception $e) {
            DB::rollback();
            return [
                "status"    => "error",
                "msg"       => $e->getMessage(),
                "data"      => []
            ];
        } 
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $data   = [
                "grup_nama"      => $request->get('grup_nama'),
            ];

            $Group   = CATGroup::find($id);
            $Group->update($data);

            DB::commit();
            return [
                "status"    => "success",
                "msg"       => "Data has been saved successfully!",
                "data"      => $Group
            ];
        }catch (\Exception $e) {
            DB::rollback();
            return [
                "status"    => "error",
                "msg"       => $e->getMessage(),
                "data"      => []
            ];
        } 
    }

    public function delete($id) {
        CATGroup::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}