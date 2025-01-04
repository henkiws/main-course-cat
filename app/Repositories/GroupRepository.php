<?php

namespace App\Repositories;

use App\Repositories\CAT\CATGroupRepository;
use App\Models\Group;
use App\Models\UserGroup;
use DB;

class GroupRepository
{
    public function __construct(CATGroupRepository $CATGroupRepository) {
        $this->CATGroupRepository = $CATGroupRepository;
    }
    
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
        DB::beginTransaction();
        try {
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

            $data_array = [
                "grup_nama" => $request->get('name')
            ];
            $newReq = new \Illuminate\Http\Request($data_array);
            $result = $this->CATGroupRepository->create($newReq);
            if( $result['status'] == "success" ) {

                $Group->update([
                    "fk_cbt_group" => $result['data']->grup_id
                ]);

                DB::commit();
                return [
                    "status"    => "success",
                    "msg"       => "Data has been saved successfully!",
                    "data"      => []
                ];
            }else{
                DB::rollback();
                return [
                    "status"    => "error",
                    "msg"       => $result['msg'],
                    "data"      => []
                ];
            }
            
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

            if( $Group->fk_cbt_group > 0 ) {
                $data_array = [
                    "grup_nama" => $request->get('name')
                ];
                $newReq = new \Illuminate\Http\Request($data_array);
                $result = $this->CATGroupRepository->update($Group->fk_cbt_group,$newReq);
                if( $result['status'] == "success" ) {
    
                    DB::commit();
                    return [
                        "status"    => "success",
                        "msg"       => "Data has been saved successfully!",
                        "data"      => []
                    ];
                }else{
                    DB::rollback();
                    return [
                        "status"    => "error",
                        "msg"       => $result['msg'],
                        "data"      => []
                    ];
                }
            }

            DB::commit();
            return [
                "status"    => "success",
                "msg"       => "Data has been saved successfully!",
                "data"      => []
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
        DB::beginTransaction();
        try {
            $Group   = Group::find($id);

            if( $Group->fk_cbt_group > 0 ) {
                $result = $this->CATGroupRepository->delete($Group->fk_cbt_group);
                if( $result['status'] == "success" ) {
                    
                    $Group->delete();
                    DB::commit();
                    return [
                        "status"    => "success",
                        "msg"       => "Data has been saved successfully!",
                        "data"      => []
                    ];
                }else{
                    DB::rollback();
                    return [
                        "status"    => "error",
                        "msg"       => $result['msg'],
                        "data"      => []
                    ];
                }
            }

            $Group->delete();
            DB::commit();
            return [
                "status"    => "success",
                "msg"       => "Deleted Successfuly",
                "data"      => []
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
    
}