<?php

namespace App\Repositories;

use App\Models\ModuleRecords;
use App\Models\GroupRecords;
use DB;

class ModuleRecordsRepository
{
    
    public function getAll() {
        return ModuleRecords::orderBy('position','ASC')->get();
    }

    public function getCount($fk_group=[]) {
        if( auth()->user()->hasRole('admin') ) {
            return ModuleRecords::count();
        }else{
            $group_record = GroupRecords::whereIn('fk_group',$fk_group)->pluck('fk_record')->toArray();
            return ModuleRecords::whereIn('id',$group_record)->count();
        }
    }

    public function getDropdown($is_premium=0) {
        return ModuleRecords::orderBy('position','ASC')->pluck('name','id');
    }

    public function getPaginate($paginate = 10, $fk_group = []) {
        if( auth()->user()->hasRole('admin') ) {
            return ModuleRecords::with(['data_group_records'])->orderBy('position','ASC')->paginate(10);
        }else{
            $group_record = GroupRecords::whereIn('fk_group',$fk_group)->pluck('fk_record')->toArray();
            return ModuleRecords::with(['data_group_records'])->whereIn('id',$group_record)->orderBy('position','ASC')->paginate(10);
        }
    }

    public function FetchById($id) {
        return ModuleRecords::findOrFail($id);
    }

    public function getByRecords($fk_record) {
        return GroupRecords::where('fk_record',$fk_record)->get();
    }

    public function create($request) {
        $data   = [
            "title"      => $request->get('title'),
            "description"      => $request->get('description'),
            "date_class"      => $request->get('date_class'),
            "tutor"      => $request->get('tutor'),
            "link"      => $request->get('link'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $ModuleRecords   = ModuleRecords::create($data);

        foreach( $request->get('fk_group') as $key => $val ) {
            GroupRecords::create([
                "fk_record" => $ModuleRecords->id,
                "fk_group" => $val
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
            "title"      => $request->get('title'),
            "description"      => $request->get('description'),
            "date_class"      => $request->get('date_class'),
            "tutor"      => $request->get('tutor'),
            "link"      => $request->get('link'),
            "position"      => $request->get('position'),
            "active"      => 1,
        ];

        $ModuleRecords   = ModuleRecords::find($id);
        $ModuleRecords->update($data);

        GroupRecords::where('fk_record',$ModuleRecords->id)->delete();

        foreach( $request->get('fk_group') as $key => $val ) {
            GroupRecords::create([
                "fk_record" => $ModuleRecords->id,
                "fk_group" => $val
            ]);
        }

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        ModuleRecords::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}