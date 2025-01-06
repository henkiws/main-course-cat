<?php

namespace App\Repositories\CAT;

use App\Models\CAT\CATTest;
use DB;

class CATTestRepository
{

    public function getAll() {
        return CATTest::get();
    }

    public function getCount() {
        return CATTest::count();
    }

    public function getDropdown($is_premium=0) {
        return CATTest::pluck('tes_nama','tes_id');
    }

    public function getPaginate($paginate = 10) {
        return CATTest::paginate(10);
    }

    public function FetchById($id) {
        return CATTest::where('tes_id',$id)->first();
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data   = [
                "tes_nama"      => $request->get('tes_nama'),
            ];

            $Group   = CATTest::create($data);
            
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
                "tes_nama"      => $request->get('tes_nama'),
            ];

            $Group   = CATTest::find($id);
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
        CATTest::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}