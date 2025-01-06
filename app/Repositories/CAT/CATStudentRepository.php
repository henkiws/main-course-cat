<?php

namespace App\Repositories\CAT;

use App\Models\CAT\CATPeserta;
use DB;

class CATStudentRepository
{

    public function getAll() {
        return CATPeserta::get();
    }

    public function getCount() {
        return CATPeserta::count();
    }

    public function getDropdown($is_premium=0) {
        return CATPeserta::pluck('grup_nama','grup_id');
    }

    public function getPaginate($paginate = 10) {
        return CATPeserta::paginate(10);
    }

    public function FetchById($id) {
        return CATPeserta::where('grup_id',$id)->first();
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data   = [
                "user_grup_id"      => $request->get('user_grup_id'),
                "user_name"      => $request->get('user_name'),
                "user_password"      => $request->get('user_password'),
                "user_email"      => $request->get('user_email'),
                "user_regdate"      => $request->get('user_regdate'),
                "user_ip"      => $request->get('user_ip'),
                "user_firstname"      => $request->get('user_firstname'),
                "user_birthdate"      => $request->get('user_birthdate'),
                "user_birthplace"      => $request->get('user_birthplace'),
                "user_level"      => $request->get('user_level'),
                "user_detail"      => $request->get('user_detail'),
            ];

            $Group   = CATPeserta::create($data);
            
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
                "user_grup_id"      => $request->get('user_grup_id'),
                "user_name"      => $request->get('user_name'),
                // "user_password"      => $request->get('user_password'),
                "user_email"      => $request->get('user_email'),
                "user_regdate"      => $request->get('user_regdate'),
                "user_ip"      => $request->get('user_ip'),
                "user_firstname"      => $request->get('user_firstname'),
                "user_birthdate"      => $request->get('user_birthdate'),
                "user_birthplace"      => $request->get('user_birthplace'),
                "user_level"      => $request->get('user_level'),
                "user_detail"      => $request->get('user_detail'),
            ];

            $Group   = CATPeserta::find($id);
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
        CATPeserta::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}