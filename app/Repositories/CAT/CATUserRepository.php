<?php

namespace App\Repositories\CAT;

use App\Models\CAT\CATUser;
use DB;

class CATUserRepository
{

    public function getAll() {
        return CATUser::get();
    }

    public function getCount() {
        return CATUser::count();
    }

    public function getDropdown($is_premium=0) {
        return CATUser::pluck('grup_nama','grup_id');
    }

    public function getPaginate($paginate = 10) {
        return CATUser::paginate(10);
    }

    public function FetchById($id) {
        return CATUser::where('grup_id',$id)->first();
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data   = [
                "username"      => $request->get('username'),
                "password"      => sha1($request->get('password')),
                "nama"      => $request->get('nama'),
                "opsi1"      => $request->get('opsi1'),
                "opsi2"      => $request->get('opsi2'),
                "keterangan"      => $request->get('keterangan'),
                "level"      => $request->get('level')
            ];

            $Group   = CATUser::create($data);
            
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
                "username"      => $request->get('username'),
                "password"      => sha1($request->get('password')),
                "nama"      => $request->get('nama'),
                "opsi1"      => $request->get('opsi1'),
                "opsi2"      => $request->get('opsi2'),
                "keterangan"      => $request->get('keterangan'),
                "level"      => $request->get('level')
            ];

            $Group   = CATUser::find($id);
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
        CATUser::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}