<?php

namespace App\Repositories;

use App\Models\ModuleFiles;
use App\Models\GroupFiles;
use App\Traits\FileUploadTrait;
use DB;

class ModuleFilesRepository
{
    use FileUploadTrait;

    public function getAll() {
        return ModuleFiles::orderBy('position','ASC')->get();
    }

    public function getDropdown($is_premium=0) {
        return ModuleFiles::orderBy('position','ASC')->pluck('name','id');
    }

    public function getPaginate($paginate = 10, $search = [], $fk_group = []) {
        $query =  ModuleFiles::with(['data_group_files']);
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        if( auth()->user()->hasRole('peserta') ) {
            $group_file = GroupFiles::whereIn('fk_group',$fk_group)->pluck('fk_module_file')->toArray();
            $query->whereIn('id',$group_file);
        }

        return $query->orderBy('position','ASC')->paginate($paginate);

        // if( auth()->user()->hasRole('admin') ) {
        //     return ModuleFiles::with(['data_group_files'])->orderBy('position','ASC')->paginate(10);
        // }else{
        //     $group_file = GroupFiles::whereIn('fk_group',$fk_group)->pluck('fk_module_file')->toArray();
        //     return ModuleFiles::with(['data_group_files'])->whereIn('id',$group_file)->orderBy('position','ASC')->paginate(10);
        // }
    }

    public function FetchById($id) {
        return ModuleFiles::findOrFail($id);
    }

    public function getByModuleFile($fk_module_file) {
        return GroupFiles::where('fk_module_file',$fk_module_file)->get();
    }

    public function create($request) {
        $data   = [
            "title"      => $request->get('title'),
            "description"      => $request->get('description'),
            "date_class"      => $request->get('date_class'),
            "tutor"      => $request->get('tutor'),
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        if( $request->file ) {
            $file   = $request->file;
            $folder = 'files';
            $res    = $this->uploadFileOnly($file,$folder);

            $data['filepath']   = $res['path'];
            $data['filename']   = $res['filename'];
        }

        $ModuleFiles   = ModuleFiles::create($data);

        foreach( $request->get('fk_group') as $key => $val ) {
            GroupFiles::create([
                "fk_module_file" => $ModuleFiles->id,
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
            "position"      => $request->get('position'),
            "active"      => 1,
            "created_by"      => auth()->user()->id,
        ];

        $ModuleFiles   = ModuleFiles::find($id);
        $ModuleFiles->update($data);

        if( $request->file ) {
            $file   = $request->file;
            $folder = 'files';
            $res    = $this->uploadFileOnly($file,$folder);

            $data['filepath']   = $res['path'];
            $data['filename']   = $res['filename'];
        }

        GroupFiles::where('fk_module_file',$ModuleFiles->id)->delete();

        foreach( $request->get('fk_group') as $key => $val ) {
            GroupFiles::create([
                "fk_module_file" => $ModuleFiles->id,
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
        ModuleFiles::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}